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
use Black\Bundle\PageBundle\Infrastructure\CQRS\Command\PublishWebPageCommand;
use Black\Bundle\PageBundle\Infrastructure\CQRS\Handler\PublishWebPageHandler;
use Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandBusInterface;

/**
 * Class PublishPageController
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PublishPageController
{
    /**
     * @var \Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandBusInterface
     */
    protected $bus;

    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\CQRS\Command\PublishWebPageCommand
     */
    protected $command;

    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\CQRS\Handler\PublishWebPageHandler
     */
    protected $handler;

    /**
     * @param CommandBusInterface $bus
     * @param PublishWebPageHandler $handler
     * @param $commandName
     */
    public function __construct(
        CommandBusInterface $bus,
        PublishWebPageHandler $handler,
        $commandName
    ) {
        $this->bus         = $bus;
        $this->handler     = $handler;
        $this->commandName = $commandName;
    }

    /**
     * @param WebPageDTO $page
     */
    public function publishPageAction(WebPageDTO $page)
    {
        $this->bus->register($this->commandName, $this->handler);
        $this->bus->handle(new PublishWebPageCommand($page->getId()));
    }
}
