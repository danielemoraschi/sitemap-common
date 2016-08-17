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
use SiteMap\Schema\SiteMapUrlCollection;

class SiteMapUrlCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider provideElements
     * @param $elements
     */
    public function testToArrayAndCount($elements)
    {
        $collection = new SiteMapUrlCollection($elements);
        $this->assertSame($elements, $collection->toArray());
        $this->assertEquals(count($elements), $collection->count());
    }

    /**
     * @dataProvider provideElements
     * @param $elements
     */
    public function testAdd($elements)
    {
        $collection = new SiteMapUrlCollection();

        foreach ($elements as $element) {
            $collection->add($element);
        }

        $this->assertSame($elements, $collection->toArray());
    }

    /**
     * @dataProvider provideElements
     * @param $elements
     */
    public function testSet($elements)
    {
        $collection = new SiteMapUrlCollection($elements);

        $newSite = new SiteMapUrl(
            new Url('http://yahoo.com'), SiteMapUrl::DAILY, 10
        );

        $collection->set(0, $newSite);
        $array = $collection->toArray();

        $this->assertSame($newSite, $array[0]);
    }

    /**
     * @dataProvider provideElements
     * @param $elements
     */
    public function testKey($elements)
    {
        $collection = new SiteMapUrlCollection($elements);
        $this->assertSame(key($elements), $collection->key());

        next($elements);

        $collection->next();
        $this->assertSame(key($elements), $collection->key());
    }

    /**
     * @dataProvider provideElements
     * @param $elements
     */
    public function testNext($elements)
    {
        $collection = new SiteMapUrlCollection($elements);

        while (true) {
            $collectionNext = $collection->next();
            $arrayNext = next($elements);

            if(!$collectionNext || !$arrayNext) {
                break;
            }

            $this->assertSame($arrayNext, $collectionNext, "Returned value of ArrayCollection::next() and next() not match");
            $this->assertSame(key($elements), $collection->key(), "Keys not match");
            $this->assertSame(current($elements), $collection->current(), "Current values not match");
        }
    }

    /**
     * @dataProvider provideElements
     * @param $elements
     */
    public function testCurrent($elements)
    {
        $collection = new SiteMapUrlCollection($elements);
        $this->assertSame(current($elements), $collection->current());

        next($elements);

        $collection->next();
        $this->assertSame(current($elements), $collection->current());
    }

    /**
     * @dataProvider provideElements
     * @param $elements
     */
    public function testIterator($elements)
    {
        $collection = new SiteMapUrlCollection($elements);
        $iterations = 0;

        foreach($collection as $key => $item) {
            $this->assertSame($elements[$key], $item, "Item {$key} not match");
            $iterations++;
        }

        $this->assertEquals(count($elements), $iterations, "Number of iterations not match");
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
