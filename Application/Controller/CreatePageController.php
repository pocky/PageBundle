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

use Black\Bundle\PageBundle\Domain\Model\WebPageId;
use Black\Bundle\PageBundle\Infrastructure\CQRS\Command\CreateWebPageCommand;
use Black\Bundle\PageBundle\Infrastructure\CQRS\Handler\CreateWebPageHandler;
use Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandBusInterface;

/**
 * Class CreatePageController
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreatePageController
{
    /**
     * @var \Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandBusInterface
     */
    protected $bus;

    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\CQRS\Command\CreateWebPageCommand
     */
    protected $command;

    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\CQRS\Handler\CreateWebPageHandler
     */
    protected $handler;

    /**
     * @param CommandBusInterface $bus
     * @param CreateWebPageHandler $handler
     * @param $commandName
     */
    public function __construct(
        CommandBusInterface $bus,
        CreateWebPageHandler $handler,
        $commandName
    ) {
        $this->bus         = $bus;
        $this->handler     = $handler;
        $this->commandName = $commandName;
    }

    /**
     * @param WebPageId $id
     * @param $author
     * @param $name
     */
    public function createPageAction(WebPageId $id, $author, $name)
    {
        $this->bus->register($this->commandName, $this->handler);
        $this->bus->handle(new CreateWebPageCommand($id, $author, $name));
    }
}
