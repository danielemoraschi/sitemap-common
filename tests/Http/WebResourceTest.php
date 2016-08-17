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


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use SiteMap\Http\Url;
use SiteMap\Http\WebResource;

class WebResourceTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testFetchContent()
    {
        $expectedContent = 'test';

        $mock = new MockHandler([
            new Response(200, [], $expectedContent),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $resource = new WebResource(new Url('http://google.com'), $client);

        $this->assertEquals($expectedContent, $resource->getContent());
    }
}
