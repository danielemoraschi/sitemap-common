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
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use SiteMap\Collect\ImageCollector;
use SiteMap\Crawler;
use SiteMap\Http\Url;
use SiteMap\Parse\RegexBasedLinkParser;
use SiteMap\Policy\SameHostPolicy;
use SiteMap\Policy\UniqueUrlPolicy;
use SiteMap\Policy\ValidExtensionPolicy;


class CrawlerTest extends \PHPUnit_Framework_TestCase
{

    public function testCrawler()
    {
        $baseUrl = new Url('http://google.com');

        $crawler = new Crawler(
            $baseUrl,
            new RegexBasedLinkParser(),
            new Client()
        );

        $crawler->setPolicies([
            'host' => new SameHostPolicy($baseUrl),
            'url'  => new UniqueUrlPolicy(),
            'ext'  => new ValidExtensionPolicy(),
        ]);

        $crawler2 = new Crawler(
            $baseUrl,
            new RegexBasedLinkParser(),
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

    public function testCollector()
    {
        $baseUrl = new Url('http://google.com');

        $crawler = new Crawler(
            $baseUrl,
            new RegexBasedLinkParser(),
            new Client()
        );

        $crawler->setPolicies([
            'host' => new SameHostPolicy($baseUrl),
            'url'  => new UniqueUrlPolicy(),
            'ext'  => new ValidExtensionPolicy(),
        ]);

        $crawler->setCollectors([
            'images' => new ImageCollector()
        ]);

        $crawler->crawl(1);

        $collected = $crawler->getCollector('images');
        $data = $collected->getCollectedData();

        $this->assertTrue(count($data) > 0);
        $this->assertTrue(count($data['http://google.com']) > 0);
    }
}
