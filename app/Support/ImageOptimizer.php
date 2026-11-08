<?php

namespace App\Support;

/**
 * Resizes and recompresses uploaded images in place (same file name and format),
 * so database references never change. Silently does nothing if GD is missing.
 */
class ImageOptimizer
{
    public const MAX_WIDTH = 1920;
    public const JPEG_QUALITY = 80;
    public const WEBP_QUALITY = 80;

    public static function available(): bool
    {
        return extension_loaded('gd');
    }

    /**
     * @return array{before:int, after:int}|null  null when skipped
     */
    public static function optimize(string $path, int $maxWidth = self::MAX_WIDTH): ?array
    {
        try {
            if (!self::available() || !is_file($path)) {
                return null;
            }
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                return null;
            }

            $before = filesize($path);

            // Phone photos keep their rotation in EXIF, which GD drops on save.
            // Read it first; if we cannot read EXIF, leave JPEGs untouched.
            $orientation = 1;
            if (in_array($ext, ['jpg', 'jpeg'], true)) {
                if (!function_exists('exif_read_data')) {
                    return null;
                }
                $exif = @exif_read_data($path);
                $orientation = (int) ($exif['Orientation'] ?? 1);
            }

            $image = self::load($path, $ext);
            if (!$image) {
                return null;
            }

            $image = self::applyOrientation($image, $orientation);
            $image = self::resize($image, $maxWidth);
            $tmp = $path.'.tmp';
            self::save($image, $tmp, $ext);
            imagedestroy($image);

            clearstatcache(true, $tmp);
            $after = is_file($tmp) ? filesize($tmp) : 0;
            // Only replace when the saving is meaningful, so running it again
            // does not keep re-encoding (and slowly degrading) the same JPEG.
            if ($after > 0 && $after < $before * 0.9) {
                rename($tmp, $path);
            } else {
                @unlink($tmp);
                $after = $before;
            }

            return ['before' => $before, 'after' => $after];
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }

    public static function load(string $path, string $ext)
    {
        $img = match ($ext) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($path),
            'png' => @imagecreatefrompng($path),
            'webp' => @imagecreatefromwebp($path),
            default => false,
        };
        if ($img && !imageistruecolor($img)) {
            imagepalettetotruecolor($img);
        }
        if ($img) {
            imagealphablending($img, false);
            imagesavealpha($img, true);
        }
        return $img;
    }

    /** Rotate/flip pixels according to the EXIF Orientation tag (1-8). */
    public static function applyOrientation($image, int $orientation)
    {
        if ($orientation <= 1 || $orientation > 8) {
            return $image;
        }
        if (in_array($orientation, [2, 4, 5, 7], true)) {
            imageflip($image, $orientation === 4 ? IMG_FLIP_VERTICAL : IMG_FLIP_HORIZONTAL);
        }
        // GD angles are counter-clockwise. Flip (above) is applied first, then rotation:
        // 2 = mirror, 3 = 180, 4 = vertical mirror, 5 = transpose, 6 = 90 CW, 7 = transverse, 8 = 90 CCW
        $angle = match ($orientation) {
            3 => 180,
            6, 7 => -90,
            5, 8 => 90,
            default => 0,
        };
        if ($angle !== 0) {
            $rotated = imagerotate($image, $angle, 0);
            if ($rotated) {
                imagedestroy($image);
                $image = $rotated;
            }
        }
        return $image;
    }

    public static function resize($image, int $maxWidth)
    {
        $w = imagesx($image);
        $h = imagesy($image);
        if ($w <= $maxWidth) {
            return $image;
        }
        $newH = (int) round($h * $maxWidth / $w);
        $resized = imagecreatetruecolor($maxWidth, $newH);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $maxWidth, $newH, $w, $h);
        imagedestroy($image);
        return $resized;
    }

    public static function save($image, string $path, string $ext): void
    {
        match ($ext) {
            'jpg', 'jpeg' => (function () use ($image, $path) {
                imageinterlace($image, true);
                imagejpeg($image, $path, self::JPEG_QUALITY);
            })(),
            'png' => imagepng($image, $path, 9),
            'webp' => imagewebp($image, $path, self::WEBP_QUALITY),
        };
    }

    /** True when the image has any (sampled) transparent pixel. */
    public static function hasTransparency($image): bool
    {
        $w = imagesx($image);
        $h = imagesy($image);
        $step = max(1, (int) floor(min($w, $h) / 80));
        for ($x = 0; $x < $w; $x += $step) {
            for ($y = 0; $y < $h; $y += $step) {
                if (((imagecolorat($image, $x, $y) >> 24) & 0x7F) > 0) {
                    return true;
                }
            }
        }
        // always check the edges and corners exactly
        foreach ([[0, 0], [$w - 1, 0], [0, $h - 1], [$w - 1, $h - 1]] as [$x, $y]) {
            if (((imagecolorat($image, $x, $y) >> 24) & 0x7F) > 0) {
                return true;
            }
        }
        return false;
    }
}
