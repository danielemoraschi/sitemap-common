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
use SiteMap\Policy\ValidExtensionPolicy;

class ValidExtensionPolicyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ValidExtensionPolicy
     */
    private $policy;

    public function setUp()
    {
        parent::setUp();
        $this->policy = new ValidExtensionPolicy();
    }

    /**
     * @dataProvider dataProvider
     *
     * @param $url
     * @param $expected
     */
    public function testUrlExtensions($url, $expected)
    {
        $newUrl = new Url($url);
        $result = $this->policy->shouldVisit($newUrl);

        $this->assertEquals($expected, $result);
    }


    public function dataProvider()
    {
        return [
            ['http://google.com/file.css', false],
            ['http://google.com/file.js', false],
            ['http://google.com/file.gif', false],
            ['http://google.com/file.jpeg', false],
            ['http://google.com/file.jpg', false],
            ['http://google.com/file.png', false],
            ['http://google.com/file.mp3', false],
            ['http://google.com/file.zip', false],
            ['http://google.com/file.tar', false],
            ['http://google.com/file.gz', false],
            ['http://google.com/file.7z', false],

            ['http://google.com/file.js?aa=34', false],
            ['http://google.com/file.js?aa=34&b=23', false],
            ['http://google.com/file.js?aa=34&b=23', false],
            ['http://google.com/file.js?aa=34#testme', false],

            ['http://google.com/file.php?aa=34', true],
            ['http://google.com/?aa=34', true],
            ['http://google.com/?aa=34#testme', true],

            ['http://google.com/file', true],
            ['http://google.com/', true],
            ['http://google.com', true],
            ['http://google.com/file.html', true],
            ['http://google.com/file.php', true],
            ['http://google.com/file.asp', true],
        ];
    }
}
