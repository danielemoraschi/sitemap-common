<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Test\Template;


use SiteMap\Schema\SiteMapUrl;
use SiteMap\Schema\SiteMapUrlCollection;
use SiteMap\Http\Url;
use SiteMap\Template\XmlTemplate;

class XmlTemplateTest extends \PHPUnit_Framework_TestCase
{

    public function testTemplate()
    {
        $url1 = new Url('http://www.google.com');
        $url2 = new Url('http://www.google.com/sub-1');
        $url3 = new Url('http://www.google.com/sub-2');
        $priority = 0.5;
        $freq = SiteMapUrl::DAILY;

        $collection = new SiteMapUrlCollection(array(
            new SiteMapUrl($url1, $freq, $priority),
            new SiteMapUrl($url2, $freq, $priority),
            new SiteMapUrl($url3, $freq, $priority),
        ));

        $tpl = new XmlTemplate();
        $content = $tpl->map($collection);

        $this->assertEquals($content, $this->expectedXml());
    }

    public function expectedXml()
    {
        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <url>
        <loc>http://www.google.com</loc>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>http://www.google.com/sub-1</loc>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>http://www.google.com/sub-2</loc>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
</urlset>
XML;
    }

}
