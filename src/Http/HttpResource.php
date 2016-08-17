<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Http;


interface HttpResource
{

    /**
     * @return mixed
     */
    public function getURI();

    /**
     * @return mixed
     */
    public function getContent();
}