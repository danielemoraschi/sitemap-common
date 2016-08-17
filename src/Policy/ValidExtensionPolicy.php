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

class ValidExtensionPolicy implements Policy
{
    
    const FILTER = ".*(\\.(css|js|gif|jpg|jpeg|png|mp3|zip|gz|tar|7z))";

    /**
     * @param Url $url
     * @return bool
     */
    public function shouldVisit(Url $url)
    {
        if (preg_match_all(
                "/" . self::FILTER . "/siU",
                $url->getWebUrl(),
                $matches,
                PREG_SET_ORDER
            ) === 0) {
            return true;
        }

        return false;
    }
}