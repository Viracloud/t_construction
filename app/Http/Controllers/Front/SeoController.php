<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use App\Models\Event;
use App\Models\Member;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;

class SeoController extends Controller
{
    /** Build every URL from APP_URL (e.g. https://affordablefinefinish.com.au), never from the request host. */
    private function useMainDomain(): void
    {
        $root = rtrim((string) config('app.url'), '/');
        if ($root !== '') {
            \Illuminate\Support\Facades\URL::forceRootUrl($root);
            if (str_starts_with($root, 'https://')) {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }
        }
    }

    /** Only slugs that produce a working URL (letters, numbers, - and _). */
    private function validSlug(?string $slug): bool
    {
        return is_string($slug) && preg_match('/^[A-Za-z0-9_-]+$/', $slug) === 1;
    }

    public function sitemap()
    {
        $this->useMainDomain();
        $urls = [];
        $add = function (string $loc, $lastmod = null, string $changefreq = 'monthly', string $priority = '0.6') use (&$urls) {
            $urls[] = [
                'loc' => $loc,
                'lastmod' => $lastmod ? \Illuminate\Support\Carbon::parse($lastmod)->toAtomString() : null,
                'changefreq' => $changefreq,
                'priority' => $priority,
            ];
        };
        $latest = fn ($model) => $model::max('updated_at');

        // Main pages
        $add(route('home'), $latest(Service::class), 'weekly', '1.0');
        $add(route('about'), null, 'monthly', '0.8');
        $add(route('services'), $latest(Service::class), 'weekly', '0.9');
        $add(route('projects'), $latest(Project::class), 'weekly', '0.8');
        $add(route('contact'), null, 'yearly', '0.8');
        $add(route('gallery'), null, 'monthly', '0.5');
        $add(route('faq'), null, 'monthly', '0.5');
        $add(route('blog'), $latest(Post::class), 'weekly', '0.7');
        $add(route('members'), $latest(Member::class), 'monthly', '0.5');
        if (Event::exists()) {
            $add(route('events'), $latest(Event::class), 'weekly', '0.5');
        }
        $add(route('terms'), null, 'yearly', '0.2');
        $add(route('privacy'), null, 'yearly', '0.2');

        // Detail pages
        foreach (Service::orderBy('id')->get(['slug', 'updated_at']) as $item) {
            if (!$this->validSlug($item->slug)) continue;
            $add(route('service', $item->slug), $item->updated_at, 'monthly', '0.9');
        }
        foreach (Project::orderBy('id')->get(['slug', 'updated_at']) as $item) {
            if (!$this->validSlug($item->slug)) continue;
            $add(route('project', $item->slug), $item->updated_at, 'monthly', '0.7');
        }
        foreach (Post::orderBy('id', 'desc')->get(['slug', 'updated_at']) as $item) {
            if (!$this->validSlug($item->slug)) continue;
            $add(route('post', $item->slug), $item->updated_at, 'monthly', '0.6');
        }
        foreach (PostCategory::has('posts')->get(['slug', 'updated_at']) as $item) {
            if (!$this->validSlug($item->slug)) continue;
            $add(route('category', $item->slug), $item->updated_at, 'weekly', '0.4');
        }
        foreach (Event::orderBy('id')->get(['slug', 'updated_at']) as $item) {
            if (!$this->validSlug($item->slug)) continue;
            $add(route('event', $item->slug), $item->updated_at, 'monthly', '0.5');
        }
        foreach (Member::orderBy('id')->get(['slug', 'updated_at']) as $item) {
            if (!$this->validSlug($item->slug)) continue;
            $add(route('member', $item->slug), $item->updated_at, 'yearly', '0.4');
        }
        foreach (CustomPage::orderBy('id')->get(['slug', 'updated_at']) as $item) {
            if (!$this->validSlug($item->slug)) continue;
            $add(route('custom_page', $item->slug), $item->updated_at, 'monthly', '0.5');
        }

        if (config('app.shop_enabled')) {
            $add(route('shop'), $latest(Product::class), 'weekly', '0.6');
            foreach (Product::orderBy('id')->get(['slug', 'updated_at']) as $item) {
                if (!$this->validSlug($item->slug)) continue;
                $add(route('product', $item->slug), $item->updated_at, 'weekly', '0.6');
            }
        }

        return response()
            ->view('front.sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots()
    {
        $this->useMainDomain();
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /forget-password',
            'Disallow: /reset-password',
            'Disallow: /dashboard',
            'Disallow: /profile',
            'Disallow: /search',
            'Disallow: /cart',
            'Disallow: /checkout',
            'Disallow: /orders',
            'Disallow: /invoice',
            'Disallow: /wishlist',
            'Disallow: /reviews',
            'Disallow: /register_verify',
            'Disallow: /subscriber',
                        '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines)."\n", 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
