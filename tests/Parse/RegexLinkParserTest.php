<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Test\Parse;


use SiteMap\Http\Url;
use SiteMap\Parse\RegexBasedLinkParser;

class RegexLinkParserTest extends \PHPUnit_Framework_TestCase
{

    public function testParser()
    {
        $parser = new RegexBasedLinkParser();
        $content = $this->getHtml();

        $parser->setContent(new Url('http://google.com'), $content);
        $links = $parser->findLinks();

        $this->assertEquals(5, count($links));
        $this->assertEquals($links[0], 'http://google.com');
        $this->assertEquals($links[1], 'http://google.com/sub1');
        $this->assertEquals($links[2], 'http://google.com/sub2');
        $this->assertEquals($links[3], 'http://google.com/sub3');
        $this->assertEquals($links[4], 'http://google.com');
    }

    public function getHtml()
    {
        return <<<HTML
<html>
<body>
<a href="http://google.com"></a>
<a href="http://google.com/sub1"></a>
<a href="http://google.com/sub2"></a>
<a href="/sub3"></a>
<a href='http://google.com'></a>
<img href="http://google.com"></img>
</body>
</html>
HTML;
    }
}
