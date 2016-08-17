<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Test\Schema;


use SiteMap\Http\Url;
use SiteMap\Schema\SiteMapUrl;

class SiteMapUrlTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidFrequency()
    {
        new SiteMapUrl(
            new Url('http://google.com'),
            'rubbish',
            10
        );
    }

    public function testEntity()
    {
        $site1 = new SiteMapUrl(
            new Url('http://google.com'),
            SiteMapUrl::DAILY,
            10
        );

        $site2 = new SiteMapUrl(
            new Url('http://google.com'),
            SiteMapUrl::DAILY,
            -10
        );

        $this->assertEquals($site1->getFrequency(), SiteMapUrl::DAILY);
        $this->assertEquals($site1->getPriority(), 10);
        $this->assertEquals($site1->getUrl()->getWebUrl(), 'http://google.com');
        $this->assertEquals($site2->getPriority(), 10);
    }

}
