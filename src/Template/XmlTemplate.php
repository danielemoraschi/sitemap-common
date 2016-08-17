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

class XmlTemplate implements Template
{

    const HEADER = <<<HTML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">\n
HTML;

    const ENTRY = <<<HTML
    <url>
        <loc>{{link}}</loc>
        <changefreq>{{frequency}}</changefreq>
        <priority>{{priority}}</priority>
    </url>\n
HTML;

    const FOOTER = <<<HTML
</urlset>
HTML;

    /**
     * @param SiteMapUrlCollection $collection
     * @return mixed|string
     */
    public function map(SiteMapUrlCollection $collection) {
        $output = '';
        /** @var SiteMapUrl $item */
        foreach ($collection as $item) {
            $output .= $this->replace(
                array('{{link}}', '{{frequency}}', '{{priority}}'),
                array($item->getUrl()->getWebUrl(), $item->getFrequency(), $item->getPriority()),
                self::ENTRY
            );
        }
        
        return self::HEADER . $output . self::FOOTER;
    }

    /**
     * @param $key
     * @param $value
     * @param $template
     * @return mixed
     */
    private function replace($key, $value, $template) {
        return str_replace($key, $value, $template);
    }
}