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
     * @var
     */
    protected $name;

    /**
     * @var \Black\Bundle\PageBundle\Domain\Model\WebPageId
     */
    protected $webPageId;

    /**
     * @param WebPageId $webPageId
     * @param $name
     */
    public function __construct(WebPageId $webPageId, $name)
    {
        $this->name      = $name;
        $this->webPageId = $webPageId;
    }

    public function getWebPageId()
    {
        return $this->webPageId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
} 