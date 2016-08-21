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

interface Collector
{
    /**
     * @param Url $url
     * @param mixed $content
     * @return mixed
     */
    public function setContent(Url $url, $content);

    /**
     * @return mixed
     */
    public function collect();

    /**
     * @return mixed
     */
    public function getCollectedData();
    
}