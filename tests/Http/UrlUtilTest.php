<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Test\Http;


use SiteMap\Http\Url;
use SiteMap\Http\UrlUtil;

class UrlUtilTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider sameHostProvider
     *
     * @param $baseUrl
     * @param $url
     * @param $expected
     */
    public function testSameHost($baseUrl, $url, $expected)
    {
        $this->assertEquals(UrlUtil::checkSameHost(
            new Url($baseUrl),
            new Url($url)
        ), $expected);
    }

    /**
     * @return array
     */
    public function sameHostProvider()
    {
        return [
            ['http://google.com', 'http://google.com', true],
            ['http://google.com', 'https://google.com', true],
            ['http://app.google.com/sub', 'http://app.google.com/sub2', true],

            ['http://google.com', 'http://google.it', false],
            ['http://google.com', 'http://app.google.com', false],
            ['http://google.com', 'http://yahoo.com', false],
        ];
    }

    /**
     * @dataProvider relativeAbsoluteProvider
     *
     * @param $relative
     * @param $absolute
     * @param $expected
     */
    public function testAbsoluteLink($relative, $absolute, $expected)
    {
        $this->assertEquals(
            UrlUtil::getAbsoluteLink(
                new Url('http://google.com'),
                $relative
            ),
            $absolute
        );
    }

    /**
     * @dataProvider relativeAbsoluteProvider
     *
     * @param $relative
     * @param $absolute
     * @param $expected
     */
    public function testIsRelative($relative, $absolute, $expected)
    {
        $this->assertEquals(
            UrlUtil::isRelative($relative),
            $expected
        );
    }

    /**
     * @return array
     */
    public function relativeAbsoluteProvider()
    {
        return [
            ['http://google.com', 'http://google.com', false],
            ['https://google.com', 'https://google.com', false],
            ['google.com', 'google.com', false],
            ['app.google.com', 'app.google.com', false],

            ['//google.com', 'http://google.com', true],
            ['//app.google.com', 'http://app.google.com', true],

            ['./sub', 'http://google.com/./sub', true],
            ['./../sub', 'http://google.com/./../sub', true],
            ['/./../sub', 'http://google.com/./../sub', true],
            ['../../sub', 'http://google.com/../../sub', true],
            ['/../../sub', 'http://google.com/../../sub', true],
            ['#sub', 'http://google.com/#sub', true],
            ['?sub=1', 'http://google.com/?sub=1', true],
            ['./?sub=1', 'http://google.com/./?sub=1', true],
        ];
    }

}