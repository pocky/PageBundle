<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\CQRS\Handler;

use Black\Bundle\PageBundle\Infrastructure\CQRS\Command\CreateWebPageCommand;
use Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface;
use Black\Bundle\PageBundle\Infrastructure\DomainEvent\WebPageCreatedEvent;
use Black\Bundle\PageBundle\Infrastructure\DomainEvent\WebPageCreatedSubscriber;
use Black\Bundle\PageBundle\Infrastructure\Service\WebPageWriteService;
use Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandHandlerInterface;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;

/**
 * Class CreateWebPageHandler
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
final class CreateWebPageHandler implements CommandHandlerInterface
{
    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\Service\WebPageWriteService
     */
    protected $service;

    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface
     */
    protected $manager;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\DomainEvent\WebPageCreatedSubscriber
     */
    protected $subscriber;

    /**
     * @param WebPageWriteService $service
     * @param WebPageManagerInterface $manager
     * @param TraceableEventDispatcher $eventDispatcher
     * @param WebPageCreatedSubscriber $subscriber
     */
    public function __construct(
        WebPageWriteService $service,
        WebPageManagerInterface $manager,
        TraceableEventDispatcher $eventDispatcher,
        WebPageCreatedSubscriber $subscriber
    ) {
        $this->service         = $service;
        $this->manager         = $manager;
        $this->eventDispatcher = $eventDispatcher;
        $this->subscriber      = $subscriber;
    }

    /**
     * @param CreateWebPageCommand $command
     * @return mixed
     */
    public function handle(CreateWebPageCommand $command)
    {
        $page = $this->service->create($this->manager, $command->getName());
        $this->manager->flush();

        $event      = new WebPageCreatedEvent($page->getWebPageId()->getValue(), $page->getName());
        $this->eventDispatcher->addSubscriber($this->subscriber);

        $this->eventDispatcher->dispatch('web_page.created', $event);
    }
} 