<?php

namespace App\Console\Commands;

use App\Support\ImageOptimizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * php artisan seo:optimize-images            -> resize + recompress every image in public/uploads (same names)
 * php artisan seo:optimize-images --convert  -> also turn large photo PNGs (no transparency) into JPG
 *                                               and update every database reference to the new file name
 */
class OptimizeImages extends Command
{
    protected $signature = 'seo:optimize-images {--convert : Convert large non-transparent PNG photos to JPG} {--min-kb=150 : Only convert PNGs larger than this}';

    protected $description = 'Compress and resize images in public/uploads for faster page loads';

    public function handle(): int
    {
        if (!ImageOptimizer::available()) {
            $this->error('PHP GD extension is not enabled. Run with: php -d extension=gd artisan seo:optimize-images');
            return self::FAILURE;
        }
        ini_set('memory_limit', '1024M');

        $dir = public_path('uploads');
        $files = glob($dir.'/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE);
        $totalBefore = $totalAfter = 0;

        foreach ($files as $path) {
            $name = basename($path);
            $before = filesize($path);

            if ($this->option('convert') && strtolower(pathinfo($name, PATHINFO_EXTENSION)) === 'png'
                && $before > (int) $this->option('min-kb') * 1024) {
                $converted = $this->convertPngToJpg($path);
                if ($converted) {
                    [$newPath, $after] = $converted;
                    $totalBefore += $before;
                    $totalAfter += $after;
                    $this->line(sprintf('%-45s %8s -> %8s  (PNG -> %s)', $name, $this->kb($before), $this->kb($after), basename($newPath)));
                    continue;
                }
            }

            $result = ImageOptimizer::optimize($path);
            if ($result) {
                $totalBefore += $result['before'];
                $totalAfter += $result['after'];
                if ($result['after'] < $result['before']) {
                    $this->line(sprintf('%-45s %8s -> %8s', $name, $this->kb($result['before']), $this->kb($result['after'])));
                }
            }
        }

        $this->info(sprintf('Total: %s -> %s', $this->kb($totalBefore), $this->kb($totalAfter)));
        return self::SUCCESS;
    }

    private function convertPngToJpg(string $path): ?array
    {
        $name = basename($path);

        // Never rename files that are hard-coded in templates or CSS
        if ($this->referencedInCode($name)) {
            return null;
        }

        $img = ImageOptimizer::load($path, 'png');
        if (!$img || ImageOptimizer::hasTransparency($img)) {
            if ($img) imagedestroy($img);
            return null;
        }

        $img = ImageOptimizer::resize($img, ImageOptimizer::MAX_WIDTH);
        // flatten onto white
        $flat = imagecreatetruecolor(imagesx($img), imagesy($img));
        imagefill($flat, 0, 0, imagecolorallocate($flat, 255, 255, 255));
        imagecopy($flat, $img, 0, 0, 0, 0, imagesx($img), imagesy($img));
        imagedestroy($img);

        $newName = pathinfo($name, PATHINFO_FILENAME).'.jpg';
        $i = 1;
        while (file_exists(dirname($path).'/'.$newName)) {
            $newName = pathinfo($name, PATHINFO_FILENAME).'-'.$i++.'.jpg';
        }
        $newPath = dirname($path).'/'.$newName;
        ImageOptimizer::save($flat, $newPath, 'jpg');
        imagedestroy($flat);

        if (filesize($newPath) >= filesize($path)) {
            unlink($newPath);
            return null;
        }

        $this->replaceInDatabase($name, $newName);
        unlink($path);

        return [$newPath, filesize($newPath)];
    }

    private function referencedInCode(string $name): bool
    {
        static $haystack = null;
        if ($haystack === null) {
            $haystack = '';
            $paths = array_merge(
                glob(resource_path('views/**/*.php')) ?: [],
                glob(resource_path('views/*/*/*.php')) ?: [],
                glob(resource_path('views/*.php')) ?: [],
                glob(public_path('dist-front/css/*.css')) ?: [],
                glob(public_path('dist-admin/css/*.css')) ?: []
            );
            foreach (array_unique($paths) as $p) {
                $haystack .= file_get_contents($p);
            }
        }
        return str_contains($haystack, $name);
    }

    private function replaceInDatabase(string $old, string $new): void
    {
        $database = DB::getDatabaseName();
        foreach (Schema::getTables() as $table) {
            // getTables() can list every database on the MySQL server; only touch this site's own
            if (isset($table['schema']) && $table['schema'] !== $database) {
                continue;
            }
            $t = $table['name'];
            foreach (Schema::getColumns($t) as $col) {
                if (preg_match('/char|text/i', $col['type'])) {
                    DB::table($t)->where($col['name'], $old)->update([$col['name'] => $new]);
                    // also references inside rich text (e.g. <img src=".../uploads/old">)
                    if (preg_match('/text/i', $col['type'])) {
                        DB::table($t)->where($col['name'], 'like', '%uploads/'.$old.'%')
                            ->update([$col['name'] => DB::raw('REPLACE(`'.$col['name'].'`, '.DB::getPdo()->quote('uploads/'.$old).', '.DB::getPdo()->quote('uploads/'.$new).')')]);
                    }
                }
            }
        }
    }

    private function kb(int $bytes): string
    {
        return $bytes >= 1048576 ? round($bytes / 1048576, 1).' MB' : round($bytes / 1024).' KB';
    }
}
