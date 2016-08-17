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


class Url
{
    /**
     * @var string
     */
    private $url;

    /**
     * Url constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $parts = parse_url($url);

        if ($parts === false || !$parts) {
            throw new \InvalidArgumentException(sprintf('Unable to parse URL: "%s"'), $url);
        }

        if (! isset($parts['scheme']) && ! isset($parts['host'])) {
            throw new \InvalidArgumentException(sprintf('Invalid URL: "%s"'), $url);
        }

        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getWebUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return parse_url($this->getWebUrl(), PHP_URL_HOST);
    }

    /**
     * @return mixed
     */
    public function getSchema()
    {
        return parse_url($this->getWebUrl(), PHP_URL_SCHEME);
    }

}