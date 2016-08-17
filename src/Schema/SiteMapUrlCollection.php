<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Schema;


class SiteMapUrlCollection implements \Iterator, \Countable
{

    /**
     * The array containing the entries of this collection.
     *
     * @var array
     */
    private $elements = array();

    /**
     * The iterator cursor
     *
     * @var int
     */
    private $index = 0;

    /**
     * Initializes a new SiteMapUrlCollection.
     *
     * @param array $elements
     */
    public function __construct(array $elements = array())
    {
        foreach ($elements as $siteMapUrl) {
            $this->add($siteMapUrl);
        }
    }

    /**
     * @param SiteMapUrl $siteMapUrl
     * @return SiteMapUrl
     */
    public function add(SiteMapUrl $siteMapUrl)
    {
        return $this->elements[] = $siteMapUrl;
    }

    /**
     * @param $offset
     * @param SiteMapUrl $siteMapUrl
     * @return SiteMapUrl
     */
    public function set($offset, SiteMapUrl $siteMapUrl)
    {
        return $this->elements[$offset] = $siteMapUrl;
    }

    /**
     * Required by interface Countable.
     *
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->elements);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * Required by interface Iterator.
     *
     * {@inheritDoc}
     */
    public function current()
    {
        return $this->elements[$this->index];
        //return current($this->elements);
    }

    /**
     * Required by interface Iterator.
     *
     * {@inheritDoc}
     */
    public function next()
    {
        $this->index ++;
        //return next($this->elements);
    }

    /**
     * Required by interface Iterator.
     *
     * {@inheritDoc}
     */
    public function key()
    {
        return $this->index;
        //return key($this->elements);
    }

    /**
     * Required by interface Iterator.
     *
     * {@inheritDoc}
     */
    public function valid()
    {
        return isset($this->elements[$this->key()]);
        //return ($this->key() < $this->count());
    }

    /**
     * Required by interface Iterator.
     *
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->index = 0;
        //return reset($this->elements);
    }

}