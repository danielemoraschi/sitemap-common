<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap;


use SiteMap\Schema\SiteMapUrl;
use SiteMap\Schema\SiteMapUrlCollection;
use SiteMap\Http\Url;
use SiteMap\Output\Writer;
use SiteMap\Template\Template;

/**
 * Class SiteMapGenerator
 * @package SiteMap
 */
class SiteMapGenerator
{

    /**
     * @var Writer
     */
    private $writer;

    /**
     * @var Template
     */
    private $template;

    /**
     * @var SiteMapUrlCollection
     */
    private $collection;

    /**
     * SiteMapGenerator constructor.
     *
     * @param Writer $writer
     * @param Template $template
     */
    public function __construct(Writer $writer, Template $template)
    {
        $this->writer = $writer;
        $this->template = $template;
        $this->collection = new SiteMapUrlCollection();
    }

    /**
     * Set the SiteMapUrlCollection for the sitemap.
     *
     * @param SiteMapUrlCollection $siteMapUrlCollection
     * @return SiteMapUrlCollection
     */
    public function setCollection(SiteMapUrlCollection $siteMapUrlCollection)
    {
        return $this->collection = $siteMapUrlCollection;
    }

    /**
     * Add a SiteMapUrl to the sitemap.
     *
     * @param SiteMapUrl $siteMapUrl
     * @return SiteMapUrl
     */
    public function addSiteMapUrl(SiteMapUrl $siteMapUrl)
    {
        return $this->collection->add($siteMapUrl);
    }

    /**
     * Add a array of SiteMapUrl to the sitemap.
     *
     * @param array $urls
     * @return $this
     */
    public function addSiteMapUrls(array $urls = array())
    {
        /** @var SiteMapUrl $siteMapUrl */
        foreach ($urls as $siteMapUrl) {
            $this->addSiteMapUrl($siteMapUrl);
        }

        return $this;
    }

    /**
     * Add URL to the sitemap
     *
     * @param mixed string|Url $url
     * @param $frequency
     * @param $priority
     * @return SiteMapUrl
     */
    public function addUrl($url, $frequency = SiteMapUrl::DAILY, $priority = 0.3)
    {
        if (! $url instanceof Url) {
            $url = new Url((string) $url);
        }

        $siteMapUrl = new SiteMapUrl(
            $url, $frequency, $priority
        );
        
        return $this->addSiteMapUrl($siteMapUrl);
    }

    /**
     * Generate the sitemap.
     *
     * @return mixed
     */
    public function execute()
    {
        $content = $this->template->map($this->collection);
        return $this->writer->write($content);
    }

}