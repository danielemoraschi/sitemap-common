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


use SiteMap\Http\Url;
use SiteMap\Output\StdOutputWriter;
use SiteMap\Schema\SiteMapUrl;
use SiteMap\Schema\SiteMapUrlCollection;
use SiteMap\SiteMapGenerator;
use SiteMap\Template\XmlTemplate;

class SiteMapGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SiteMapGenerator
     */
    private $generator;

    public function setUp()
    {
        parent::setUp();
        $writer = $this->getMock('\SiteMap\Output\File\FileWriter', array(), array('sitemap.xml'));
        $this->generator = new SiteMapGenerator(
            $writer, new XmlTemplate()
        );
    }

    /**
     * @dataProvider provideElements
     * @param $elements
     */
    public function testSetCollection($elements)
    {
        $collection = new SiteMapUrlCollection($elements);
        $this->assertSame($collection, $this->generator->setCollection($collection));
    }

    /**
     * @dataProvider provideElements
     * @param $elements
     */
    public function testAddSiteMapUrl($elements)
    {
        foreach ($elements as $siteMap) {
            $this->assertSame($siteMap, $this->generator->addSiteMapUrl($siteMap));
        }
    }

    /**
     * @dataProvider provideElements
     * @param $elements
     */
    public function testAddUrl($elements)
    {
        /** @var SiteMapUrl $siteMap */
        foreach ($elements as $siteMap) {
            $this->assertTrue(
                $siteMap
                ==
                $this->generator->addUrl(
                    $siteMap->getUrl(),
                    $siteMap->getFrequency(),
                    $siteMap->getPriority()
                )
            );
        }
    }

    /**
     * @dataProvider provideElements
     * @param $elements
     */
    public function testExecute($elements)
    {
        $this->generator = new SiteMapGenerator(
            new StdOutputWriter(), new XmlTemplate()
        );

        $collection = new SiteMapUrlCollection($elements);
        $this->generator->setCollection($collection);

        ob_start();
        $this->generator->execute();
        $result = ob_get_contents();
        ob_end_clean();

        $this->assertTrue(strlen($result) > 0);
    }

    /**
     * @return array
     */
    public function provideElements()
    {
        $site = new SiteMapUrl(
            new Url('http://google.com'), SiteMapUrl::DAILY, 10
        );

        return [
            'test' => [[$site, $site, $site, $site]]
        ];
    }

}
