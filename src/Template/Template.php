<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Template;

use SiteMap\Schema\SiteMapUrlCollection;

interface Template
{

    /**
     * @param SiteMapUrlCollection $collection
     * @return mixed
     */
    public function map(SiteMapUrlCollection $collection);
}