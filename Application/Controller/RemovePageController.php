<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\Controller;

use Black\Bundle\PageBundle\Application\DTO\WebPageDTO;
use Black\Bundle\PageBundle\Domain\Model\WebPageId;
use Black\Bundle\PageBundle\Infrastructure\CQRS\Command\RemoveWebPageCommand;
use Black\Bundle\PageBundle\Infrastructure\CQRS\Handler\RemoveWebPageHandler;
use Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandBusInterface;

/**
 * Class RemovePageController
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class RemovePageController
{
    /**
     * @var \Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandBusInterface
     */
    protected $bus;

    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\CQRS\Command\RemoveWebPageCommand
     */
    protected $command;

    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\CQRS\Handler\RemoveWebPageHandler
     */
    protected $handler;

    /**
     * @param CommandBusInterface $bus
     * @param RemoveWebPageHandler $handler
     * @param $commandName
     */
    public function __construct(
        CommandBusInterface $bus,
        RemoveWebPageHandler $handler,
        $commandName
    ) {
        $this->bus         = $bus;
        $this->handler     = $handler;
        $this->commandName = $commandName;
    }

    /**
     * @param WebPageDTO $page
     */
    public function removePageAction(WebPageId $id)
    {
        $this->bus->register($this->commandName, $this->handler);
        $this->bus->handle(new RemoveWebPageCommand($id));
    }
}
