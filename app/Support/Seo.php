<?php

namespace App\Support;

use Illuminate\Support\Str;

class Seo
{
    /** Plain-text excerpt for meta descriptions (strips HTML, decodes entities, collapses spaces). */
    public static function text(?string $html, int $limit = 160): string
    {
        $text = html_entity_decode(strip_tags((string) $html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = trim(preg_replace('/\s+/u', ' ', str_replace("\xC2\xA0", ' ', $text)));
        return Str::limit($text, $limit - 3, '...');
    }

    /** "Item title | Site Name", unless an explicit SEO title was entered. */
    public static function title(?string $seoTitle, ?string $title, ?string $siteName): string
    {
        if (filled($seoTitle)) {
            return trim($seoTitle);
        }
        $siteName = $siteName ?: config('app.name');
        return trim(($title ? $title.' | ' : '').$siteName);
    }

    public static function description(?string $seoDescription, ?string ...$fallbacks): string
    {
        if (filled($seoDescription)) {
            return self::text($seoDescription, 300);
        }
        foreach ($fallbacks as $fallback) {
            if (filled(strip_tags((string) $fallback))) {
                return self::text($fallback);
            }
        }
        return '';
    }
}
