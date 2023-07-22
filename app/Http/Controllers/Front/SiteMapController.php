<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Domain;

class SiteMapController extends Controller
{
    const WEBSITE_PAGES = [
        'https://www.identitius.com/',
        'https://www.identitius.com/about',
        'https://www.identitius.com/domains',
        'https://www.identitius.com/fees',
        'https://www.identitius.com/domain-owners',
        'https://www.identitius.com/domain-renters',
        'https://www.identitius.com/q-and-a',
        'https://www.identitius.com/login',
        'https://www.identitius.com/register',
        'https://www.identitius.com/tos',
        'https://www.identitius.com/privacy-policy',
        'https://www.identitius.com/cookie-policy',
        'https://www.identitius.com/disclaimer',
        'https://www.identitius.com/ccpa-do-not-sell',
        'https://www.identitius.com/password/reset',
        'https://www.identitius.com/terms-and-conditions',
    ];


    const SITEMAP_HOME = [
        'https://www.identitius.com/page-sitemap.xml',
        'https://www.identitius.com/domain-sitemap.xml',
    ];

    /**
     * This function is used to generate the sitemap
     * @method GET /sitemap.xml
     * @return XML
     */
    public function index()
    {
        return response($this->generateSitemap(self::SITEMAP_HOME), 200)->header('Content-Type', 'application/xml');
    }

    /**
     * This function is used to generate the page sitemap
     * @method GET /page-sitemap.xml
     * @return XML
     */
    public function pageSitemap()
    {
        return response($this->generateSitemap(self::WEBSITE_PAGES), 200)->header('Content-Type', 'application/xml');
    }

    /**
     * This function is used to generate the domain sitemap
     * @method GET /domain-sitemap.xml
     * @return XML
     */
    public function domainSitemap()
    {
        $domains = Domain::get();
        foreach ($domains as $domain) {
            $domainUrl[] = url($domain->domain);
        }
         return response($this->generateSitemap($domainUrl), 200)->header('Content-Type', 'application/xml');
    }

    /**
     * This function is used to generate the sitemap
     * @param SitemapUrls
     * @return XML
     */
     public function generateSitemap($allSitemapUrls)
     {
         $sitemap = '<?xml version="1.0" encoding="UTF-8"?> <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
         foreach ($allSitemapUrls as $allSitemapUrl) {
             $sitemap .= '<url><loc>' . $allSitemapUrl . '</loc>' . '<lastmod>' . date('Y-m-d') . '</lastmod>' . '</url>';
         }
         $sitemap .= '</urlset>';
         return $sitemap;
     }
}
