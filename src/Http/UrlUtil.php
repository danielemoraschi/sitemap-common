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


class UrlUtil
{

    /**
     * @param Url $baseUrl
     * @param Url $url
     * @return bool
     * @throws \RuntimeException
     */
    public static function checkSameHost(Url $baseUrl, Url $url)
    {
        if ($baseUrl->getHost() == null) {
            throw new \RuntimeException("Base URL is null");
        }

        return $baseUrl->getHost() == $url->getHost();
    }

    /**
     * @param Url $baseUrl
     * @param $link
     * @return string
     */
    public static function getAbsoluteLink(Url $baseUrl, $link)
    {
        if (self::isSlashed($link)) {
            return self::addSchema($baseUrl, $link);
        }
        
        if (self::isRelative($link)) {
            return self::buildUrl($baseUrl, $link);
        }

        return $link;
    }

    /**
     * @TODO Improve this, definitely not the most elegant way.
     * @param $link
     * @return bool
     */
    public static function isRelative($link)
    {

        return $link[0] === '/'
            || $link[0] === '#'
            || $link[0] === '?'
            || $link[0].$link[1].$link[2] === '../'
            || $link[0].$link[1] === './'
            || self::isPathOnly($link);
    }

    /**
     * @param $link
     * @return bool
     */
    public static function isPathOnly($link)
    {
        $parts = parse_url($link);
        return count($parts) === 1 && isset($parts['path']);
    }

    /**
     * @TODO Improve this, definitely not the most elegant way.
     * @param $link
     * @return bool
     */
    public static function isSlashed($link) {
        return $link[0].$link[1] === '//';
    }

    /**
     * @param Url $baseUrl
     * @param $partial
     * @return string
     */
    public static function buildUrl(Url $baseUrl, $partial)
    {
        return rtrim($baseUrl->getWebUrl(), '/') .'/'. ltrim($partial, '/');
    }

    /**
     * @param Url $baseUrl
     * @param $partial
     * @return string
     */
    public static function addSchema(Url $baseUrl, $partial)
    {
        return $baseUrl->getSchema() .':'. $partial;
    }
}