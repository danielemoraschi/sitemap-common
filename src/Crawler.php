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
     *
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
     * Add a new crawler policy.
     *
     * @param $key
     * @param Policy $policy
     */
    public function setPolicy($key, Policy $policy)
    {
        $this->policies[(string)$key] = $policy;
    }

    /**
     * Set crawler policies to follow the URLs
     * of a webpage.
     *
     * @param array $policies
     */
    public function setPolicies(array $policies)
    {
        foreach ($policies as $key => $policy) {
            $this->setPolicy($key, $policy);
        }
    }

    /**
     * Will return true|false if the URL passed as argument should
     * be visited by the crawler based upon policies.
     *
     * @param Url $url
     * @return bool
     */
    public function shouldVisit(Url $url)
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
     * Visit a webpage.
     *
     * @TODO handle the exception
     * @param HttpResource $httpResource
     * @return array
     */
    private function visit(HttpResource $httpResource)
    {
        try {
            $webPage = $httpResource->getContent();
        } catch (\Exception $e) {
            return array();
        }

        $this->parser->setContent($httpResource->getURI(), $webPage);
        $links = $this->parser->findLinks();
        return $links;
    }

    /**
     * This method will return the array of visited URLs by the crawler
     * based upon specified deep scan and policies.
     *
     * @param $maxDeep
     * @return array|mixed
     */
    public function crawl($maxDeep = 1)
    {
        $deepness = 0;
        $maxDeep = abs((int)$maxDeep);
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
        return $this->getUrlArray($linksCollection);
    }

    /**
     * @param array $links
     * @return array
     */
    protected function getUrlArray(array $links = array())
    {
        return array_map(function($webUrl) {
            return new Url($webUrl);
        }, array_unique($links));
    }
}