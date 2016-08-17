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

class UniqueUrlPolicy implements Policy
{
    /**
     * @var array
     */
    private $cache = [];

    /**
     * @param Url $url
     * @return bool
     */
    public function shouldVisit(Url $url)
    {
        if (isset($this->cache[$url->getWebUrl()])) {
            return false;
        }

        return $this->cache[$url->getWebUrl()] = true;
    }

    /**
     * @return mixed
     */
    public function reset()
    {
        $this->cache = [];
        return $this;
    }
}