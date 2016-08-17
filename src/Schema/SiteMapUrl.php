<?php
/**
 * This file is part of sitemap-common.
 *
 * (c) 2016 Daniele Moraschi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SiteMap\Schema;


use SiteMap\Http\Url;

class SiteMapUrl
{

    const DAILY     = 'daily';
    const WEEKLY    = 'weekly';
    const MONTHLY   = 'monthly';
    const YEARLY    = 'yearly';

    /**
     * @var Url
     */
    private $url;

    /**
     * @var string
     */
    private $frequency;

    /**
     * @var float
     */
    private $priority;

    /**
     * SiteMapUrl constructor.
     * @param Url $url
     * @param string $frequency
     * @param float $priority
     */
    public function __construct(Url $url, $frequency, $priority)
    {
        $this->url = $url;
        $this->priority = abs(number_format($priority, 1));
        $this->setFrequency($frequency);
    }

    /**
     * @return Url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @return float
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param string $frequency
     */
    protected function setFrequency($frequency)
    {
        switch ($frequency) {
            case self::DAILY:
            case self::WEEKLY:
            case self::MONTHLY:
            case self::YEARLY:
                $this->frequency = $frequency;
                break;
            default:
                throw new \InvalidArgumentException(
                    sprintf('Invalid frequency "%s" for URL "%s"', $frequency, $this->url->getWebUrl())
                );
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'url' => $this->getUrl()->getWebUrl(),
            'priority' => $this->getPriority(),
            'frequency' => $this->getFrequency(),
        );
    }

}