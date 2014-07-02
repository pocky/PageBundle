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
use Black\Bundle\PageBundle\Infrastructure\CQRS\Command\WriteWebPageCommand;
use Black\Bundle\PageBundle\Infrastructure\CQRS\Handler\WriteWebPageHandler;
use Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandBusInterface;

/**
 * Class WritePageController
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WritePageController
{
    /**
     * @var \Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandBusInterface
     */
    protected $bus;

    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\CQRS\Command\WriteWebPageCommand
     */
    protected $command;

    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\CQRS\Handler\WriteWebPageHandler
     */
    protected $handler;

    /**
     * @param CommandBusInterface $bus
     * @param WriteWebPageHandler $handler
     * @param $commandName
     */
    public function __construct(
        CommandBusInterface $bus,
        WriteWebPageHandler $handler,
        $commandName
    ) {
        $this->bus         = $bus;
        $this->handler     = $handler;
        $this->commandName = $commandName;
    }

    /**
     * @param WebPageDTO $page
     */
    public function writePageAction(WebPageDTO $page)
    {
        $bus = $this->bus;

        $bus->register($this->commandName, $this->handler);
        $bus->handle(
            new WriteWebPageCommand($page->getId(), $page->getHeadline(), $page->getAbout(), $page->getText())
        );
    }
}