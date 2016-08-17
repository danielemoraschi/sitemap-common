<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Output;


class StdOutputWriter implements Writer
{
    /**
     * @param $content
     * @return mixed
     */
    public function write($content)
    {
        echo $content . "\n";
        return true;
    }
}