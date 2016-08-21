<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Test\Collect;


use SiteMap\Collect\ImageCollector;
use SiteMap\Http\Url;

class ImageCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testParser()
    {
        $parser = new ImageCollector();
        $content = $this->getHtml();

        $parser->setContent(new Url('http://google.com'), $content);
        $data = $parser->collect()->getCollectedData();

        $this->assertEquals(1, count($data));
        $this->assertEquals(10, count($data['http://google.com']));
    }

    public function getHtml()
    {
        return <<<HTML
<html>
<body>
<img src="http://google.com/image2.js" />
<img src="http://google.com/image.gif" alt="first alt"></img>
<img src="http://google.com/image.gif" alt="second alt"></img>
<img src='http://google.com/image2.gif' />
<img src="http://google.com/image.png?site=&amp;ie=UTF-8&amp;q=Ol"></img>
<img src="http://google.com/image.jpg"></img>
<img src="http://google.com/image.jpeg"></img>
<img src="http://google.com/image.tif"></img>
<img src="image.jpg"></img>
<img src='/image.jpg'></img>
<img src="//image.jpg"></img>
</body>
</html>
HTML;
    }
}
