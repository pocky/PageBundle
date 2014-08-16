<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\CQRS\Command;

use Black\Bundle\PageBundle\Domain\Model\WebPageId;
use Black\DDD\CQRSinPHP\Infrastructure\CQRS\CommandInterface;

/**
 * Class WriteWebPageCommand
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
final class WriteWebPageCommand implements CommandInterface
{
    /**
     * @var \Black\Bundle\PageBundle\Domain\Model\WebPageId
     */
    protected $webPageId;

    /**
     * @var
     */
    protected $headline;

    /**
     * @var
     */
    protected $about;

    /**
     * @var
     */
    protected $text;

    /**
     * @param WebPageId $webPageId
     * @param $headline
     * @param $about
     * @param $text
     */
    public function __construct(WebPageId $webPageId, $headline, $about, $text)
    {
        $this->webPageId = $webPageId;
        $this->headline  = $headline;
        $this->about     = $about;
        $this->text      = $text;
    }

    /**
     * @return mixed
     */
    public function getWebPageId()
    {
        return $this->webPageId;
    }

    /**
     * @return mixed
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * @return mixed
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }
}