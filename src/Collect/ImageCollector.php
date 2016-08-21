<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Collect;


use SiteMap\Http\Url;
use SiteMap\Http\UrlUtil;

class ImageCollector implements Collector
{

    /**
     * @var string  REGEX
     */
    const REGEX = "/(img|src)=(\"|')[^\"'>]+\.(gif|jpg|jpeg|png|tif|svg)/i";
    const REGEX2 = "/(img|src)(\"|'|=\"|=')(.*)/i";

    /**
     * @var Url
     */
    private $url;

    /**
     * @var string
     */
    private $content;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param Url $url
     * @param mixed $content
     * @return $this
     */
    public function setContent(Url $url, $content)
    {
        $this->url = $url;
        $this->content = (string) $content;
        return $this;
    }

    /**
     * @return $this
     */
    public function collect()
    {
        if(! isset($this->data[$this->url->getWebUrl()])) {
            $this->data[$this->url->getWebUrl()] = [];
        }

        preg_match_all(self::REGEX, $this->content, $media);
        $data = preg_replace(self::REGEX2, "$3", $media[0]);
        foreach($data as $url) {
            $this->data[$this->url->getWebUrl()][] =
                UrlUtil::getAbsoluteLink($this->url, $url);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getCollectedData()
    {
        return $this->data;
    }

}