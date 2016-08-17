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

use GuzzleHttp\ClientInterface;

class WebResource implements HttpResource
{

    /**
     * @var Url  $url
     */
    private $url;

    /**
     * @var mixed
     */
    private $content;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * WebResource constructor.
     *
     * @var Url  $url
     * @var ClientInterface  $client
     */
    public function __construct(Url $url, ClientInterface $httpClient)
    {
        $this->url = $url;
        $this->httpClient = $httpClient;
    }

    /**
     * @return Url
     */
    public function getURI()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        if (! $this->content) {
            $this->content = (string) $this->fetchContent();
        }

        return $this->content;
    }

    /**
     * @return mixed
     */
    private function fetchContent()
    {
        $response = $this->httpClient->get($this->getURI()->getWebUrl());
        return $response->getBody(true);
    }

}