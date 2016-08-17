<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Test\Output;


use SiteMap\Output\File\FileWriter;

class FileWriterTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testWritableFile()
    {
        $writer = new FileWriter('/tmp/test-file.txt');
        $writer->write("TEST");
        $content = file_get_contents('/tmp/test-file.txt');
        $this->assertTrue($content == "TEST");
    }

    /**
     * @expectedException \SiteMap\Output\File\FileWriterException
     */
    public function testUnWritableFile()
    {
        $writer = new FileWriter('!/root/test-file.txt');
        $writer->write("TEST");
    }
}
