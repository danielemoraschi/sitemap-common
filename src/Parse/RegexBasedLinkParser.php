<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Parse;

use SiteMap\Http\Url;
use SiteMap\Http\UrlUtil;

final class RegexBasedLinkParser implements LinkParser, Parser
{
    /**
     * @var string  REGEX
     */
    const REGEX = "<a\s[^>]*href=([\"\']??)([^\\1 >]*?)\\1[^>]*>(.*)<\/a>";

    /**
     * @var Url
     */
    private $url;

    /**
     * @var string
     */
    private $webPageContent;

    /**
     * @var array $pages
     */
    private $pages;

    /**
     * @param Url $url
     * @param mixed $content
     * @return mixed
     */
    public function setContent(Url $url, $content)
    {
        $this->pages = array();
        $this->url = $url;
        $this->webPageContent = (string) $content;
        return $this;
    }

    /**
     * @return array
     */
    public function findLinks() {
        return $this->parse();
    }

    /**
     * @return array
     */
    public function parse() {
        if (empty($this->pages) && preg_match_all(
            "/" . self::REGEX . "/siU",
            $this->webPageContent,
            $matches,
            PREG_SET_ORDER
        )) {
            foreach ($matches as $match) {
                $this->pages[] = trim(UrlUtil::getAbsoluteLink($this->url, $match[2]));
            }
        }

        return $this->pages;
    }
    
}