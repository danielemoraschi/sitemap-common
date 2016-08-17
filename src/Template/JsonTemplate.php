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


use SiteMap\Schema\SiteMapUrl;
use SiteMap\Schema\SiteMapUrlCollection;

class JsonTemplate implements Template
{

    public function map(SiteMapUrlCollection $collection)
    {
        $base = $collection[0]->getUrl()->getHost();
        $jsonOutput[$base] = array();

        /** @var SiteMapUrl $item */
        foreach ($collection as $item) {
            $jsonOutput[$base]['urls'][] = $item->toArray();
        }

        $jsonOutput[$base]['total'] = $collection->count();

        return json_encode($jsonOutput);
    }
}