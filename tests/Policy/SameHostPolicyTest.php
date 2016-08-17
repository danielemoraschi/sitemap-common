<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Test\Policy;


use SiteMap\Http\Url;
use SiteMap\Policy\SameHostPolicy;

class SameHostPolicyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @param $baseUrl
     * @param $url
     * @param $expected
     */
    public function testSameHost($baseUrl, $url, $expected)
    {
        $baseUrl = new Url($baseUrl);
        $newUrl = new Url($url);

        $policy = new SameHostPolicy($baseUrl);
        $result = $policy->shouldVisit($newUrl);

        $this->assertEquals($expected, $result);
    }


    public function dataProvider()
    {
        return [
            ['http://google.com', 'http://google.com', true],
            ['http://google.com', 'http://google.com/search', true],
            ['http://google.com/profile', 'http://google.com/search/something', true],
            ['https://google.com', 'http://google.com', true],

            ['https://plus.google.com', 'https://www.google.com', false],
            ['https://plus.google.com', 'http://yahoo.com', false],
            ['https://google.com', 'http://yahoo.com', false],
        ];
    }
    
}
