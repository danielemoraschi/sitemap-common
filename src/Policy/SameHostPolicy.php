<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Policy;

use SiteMap\Http\Url;
use SiteMap\Http\UrlUtil;

class SameHostPolicy implements Policy
{
    /**
     * @var Url
     */
    private $baseUrl;

    /**
     * SameHostPolicy constructor.
     * @param Url $baseUrl
     */
    public function __construct(Url $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param Url $url
     * @return bool
     */
    public function shouldVisit(Url $url)
    {
        return UrlUtil::checkSameHost($this->baseUrl, $url);
    }
}