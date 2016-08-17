<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Output\File;

use SiteMap\Output\Writer;

class FileWriter implements Writer
{

    /**
     * @var string
     */
    private $fileName;

    /**
     * FileWriter constructor.
     * @param $fileName
     */
    public function __construct($fileName)
    {
        $this->fileName = (string)$fileName;
    }

    /**
     * @param $fileName
     * @param $fileContent
     * @return mixed
     */
    public function write($fileContent)
    {
        try {
            $success = file_put_contents($this->fileName, $fileContent);
            if (false === $success) {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            throw new FileWriterException(sprintf('Cannot write the file at location %s', $this->fileName));
        }

        return true;
    }
}