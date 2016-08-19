<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap;


use GuzzleHttp\ClientInterface;
use SiteMap\Http\HttpResource;
use SiteMap\Http\WebResource;
use SiteMap\Http\Url;
use SiteMap\Parse\LinkParser;
use SiteMap\Policy\Policy;

class Crawler
{

    /**
     * @var Url
     */
    private $baseUrl;

    /**
     * @var LinkParser
     */
    private $parser;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var array
     */
    private $policies = [];

    /**
     * Crawler constructor.
     * @param Url $baseUrl
     * @param LinkParser $parser
     * @param ClientInterface $httpClient
     */
    public function __construct(Url $baseUrl, LinkParser $parser, ClientInterface $httpClient)
    {
        $this->baseUrl = $baseUrl;
        $this->parser = $parser;
        $this->httpClient = $httpClient;
    }

    /**
     * @param $key
     * @param Policy $policy
     */
    public function setPolicy($key, Policy $policy)
    {
        $this->policies[(string)$key] = $policy;
    }

    /**
     * @param array $policies
     */
    public function setPolicies(array $policies)
    {
        foreach ($policies as $key => $policy) {
            $this->setPolicy($key, $policy);
        }
    }

    /**
     * @param Url $url
     * @return bool
     */
    protected function shouldVisit(Url $url)
    {
        /** @var Policy $policy */
        foreach ($this->policies as $key => $policy) {
            if (! $policy->shouldVisit($url)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param HttpResource $httpResource
     * @return array
     */
    private function visit(HttpResource $httpResource)
    {
        $webPage = $httpResource->getContent();
        $this->parser->setContent($httpResource->getURI(), $webPage);
        $links = $this->parser->findLinks();
        return $links;
    }

    /**
     * @param $maxDeep
     * @return array|mixed
     */
    public function crawl($maxDeep = 1)
    {
        $deepness = 0;
        $linksCollection = array_fill(0, $maxDeep+1, []);

        $linksCollection[0] = array($this->baseUrl->getWebUrl());

        while ($deepness < $maxDeep) {
            $deepness++;
            foreach ($linksCollection[$deepness-1] as $webUrl) {
                $url = new Url($webUrl);
                if ($this->shouldVisit($url)) {
                    $linksCollection[$deepness] += $this->visit(
                        new WebResource($url, $this->httpClient)
                    );
                }
            }
        }

        $linksCollection = call_user_func_array('array_merge', $linksCollection);
        return $this->getUrlCollection($linksCollection);
    }

    /**
     * @param array $links
     * @return array
     */
    protected function getUrlCollection(array $links = array())
    {
        return array_map(function($webUrl) {
            return new Url($webUrl);
        }, array_unique($links));
    }
}