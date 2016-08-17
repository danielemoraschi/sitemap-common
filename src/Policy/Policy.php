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

interface Policy
{
    /**
     * @param Url $url
     * @return mixed
     */
    public function shouldVisit(Url $url);
}