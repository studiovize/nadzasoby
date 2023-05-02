<?php

namespace App\Http\Controllers;

use App\Models\Listing;

class SitemapController extends Controller
{
    public function generate()
    {
        $routes = [
            '' => '1.0',
            '/about' => '0.7',
            '/search' => '0.9',
            '/login' => '0.7',
            '/register' => '0.7',
            '/register-personal' => '0.7',
            '/register-company' => '0.7',
            '/forgot-password' => '0.7',
            '/credits' => '0.7',
            '/plans/20' => '0.7',
            '/plans/50' => '0.7',
            '/plans/100' => '0.7',
            '/plans/999' => '0.7',
            '/faq' => '0.7',
            '/contact' => '0.7',
            '/docs/terms' => '0.7',
            '/docs/personal-data' => '0.7'
        ];

        // 1.0 - listings
        // 0.9 - search
        // 0.7 - others

        $listings_raw = Listing::where([
            ['is_active', '=', true],
            ['is_approved', '=', true],
        ])->pluck('slug')
            ->map(function ($val) {
                return '/' . $val;
            })
            ->toArray();

        $listings = [];

        foreach ($listings_raw as $listing) {
            $listings[$listing] = '1.0';
        }

        $routes = array_merge($routes, $listings);

        $xml = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">',
        ];

        foreach ($routes as $route => $priority) {
            $freq = 'daily';
            if ($priority === '0.7') $freq = 'monthly';

            $item = [
                '<url>',
                "<loc>https://www.nadzasoby.cz{$route}</loc>",
                "<changefreq>{$freq}</changefreq>",
                "<priority>{$priority}</priority>",
                '<lastmod>' . date('c', time()) . '</lastmod>',
                '</url>'
            ];

            $xml[] = implode('', $item);
        }

        $xml[] = '</urlset>';

        $xml = implode('', $xml);

        file_put_contents(public_path('sitemap.xml'), $xml);

        echo "Sitemap generated";
        die();
    }
}
