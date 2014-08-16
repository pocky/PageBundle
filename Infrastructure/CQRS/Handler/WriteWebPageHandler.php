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

use Black\Bundle\PageBundle\Infrastructure\CQRS\Command\WriteWebPageCommand;
use Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface;
use Black\Bundle\PageBundle\Infrastructure\DomainEvent\WebPageWritedEvent;
use Black\Bundle\PageBundle\Infrastructure\DomainEvent\WebPageWritedSubscriber;
use Black\Bundle\PageBundle\Infrastructure\Service\WebPageWriteService;
use Black\DDD\CQRSinPHP\Infrastructure\CQRS\CommandHandlerInterface;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;

/**
 * Class WriteWebPageHandler
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
final class WriteWebPageHandler implements CommandHandlerInterface
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
     * @var \Black\Bundle\PageBundle\Infrastructure\DomainEvent\WebPageWritedSubscriber
     */
    protected $subscriber;

    /**
     * @param WebPageWriteService $service
     * @param WebPageManagerInterface $manager
     * @param TraceableEventDispatcher $eventDispatcher
     * @param WebPageWritedSubscriber $subscriber
     */
    public function __construct(
        WebPageWriteService $service,
        WebPageManagerInterface $manager,
        TraceableEventDispatcher $eventDispatcher,
        WebPageWritedSubscriber $subscriber
    ) {
        $this->service         = $service;
        $this->manager         = $manager;
        $this->eventDispatcher = $eventDispatcher;
        $this->subscriber      = $subscriber;
    }

    /**
     * @param WriteWebPageCommand $command
     * @return mixed
     */
    public function handle(WriteWebPageCommand $command)
    {
        $page = $this->service->write(
            $command->getWebPageId(),
            $command->getHeadline(),
            $command->getAbout(),
            $command->getText()
        );

        $this->manager->flush();

        $event = new WebPageWritedEvent($page->getWebPageId()->getValue(), $page->getName());
        $this->eventDispatcher->addSubscriber($this->subscriber);
        $this->eventDispatcher->dispatch('web_page.writed', $event);
    }
}