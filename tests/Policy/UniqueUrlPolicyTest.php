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
use SiteMap\Policy\UniqueUrlPolicy;

class UniqueUrlPolicyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UniqueUrlPolicy
     */
    private $policy;

    public function testSameInstance()
    {
        $this->policy = new UniqueUrlPolicy();
        $data = $this->urlsProvider();

        foreach ($data as $toTest) {
            $newUrl = new Url($toTest[0]);
            $result = $this->policy->shouldVisit($newUrl);
            $this->assertEquals($toTest[1], $result);
        }
    }

    public function urlsProvider()
    {
        return [
            ['http://google.com', true],
            ['http://google.com', false],
            ['http://google.com', false],
            ['http://google.com', false],
            ['http://yahoo.com', true],
        ];
    }

}
