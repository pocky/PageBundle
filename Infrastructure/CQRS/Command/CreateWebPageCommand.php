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
use Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandInterface;

/**
 * Class CreateWebPageCommand
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
final class CreateWebPageCommand implements CommandInterface
{
    /**
     * @var \Black\Bundle\PageBundle\Domain\Model\WebPageId
     */
    protected $webPageId;

    /**
     * @var
     */
    protected $author;

    /**
     * @var
     */
    protected $name;

    /**
     * @param WebPageId $webPageId
     * @param $author
     * @param $name
     */
    public function __construct(WebPageId $webPageId, $author, $name)
    {
        $this->webPageId = $webPageId;
        $this->author    = $author;
        $this->name      = $name;
    }

    /**
     *
     */
    public function getWebPageId()
    {
        return $this->webPageId;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
} 