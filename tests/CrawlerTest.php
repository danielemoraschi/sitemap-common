<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Test;


use GuzzleHttp\Client;
use SiteMap\Crawler;
use SiteMap\Http\Url;
use SiteMap\Parse\RegexLinkParser;
use SiteMap\Policy\SameHostPolicy;
use SiteMap\Policy\UniqueUrlPolicy;
use SiteMap\Policy\ValidExtensionPolicy;


class CrawlerTest extends \PHPUnit_Framework_TestCase
{

    public function testCrawler()
    {
        $baseUrl = new Url('http://asaquattrocento.com');

        $crawler = new Crawler(
            $baseUrl,
            new RegexLinkParser(),
            new Client()
        );

        $crawler->setPolicies([
            'host' => new SameHostPolicy($baseUrl),
            'url'  => new UniqueUrlPolicy(),
            'ext'  => new ValidExtensionPolicy(),
        ]);

        $crawler2 = new Crawler(
            $baseUrl,
            new RegexLinkParser(),
            new Client()
        );

        $crawler2->setPolicies([
            'host' => new SameHostPolicy($baseUrl),
            'url'  => new UniqueUrlPolicy(),
            'ext'  => new ValidExtensionPolicy(),
        ]);

        $links = $crawler->crawl(1);

        $this->assertTrue(count($links) > 0);
        
        $links2 = $crawler2->crawl(2);
        
        $this->assertTrue(count($links2) > count($links));
    }
}