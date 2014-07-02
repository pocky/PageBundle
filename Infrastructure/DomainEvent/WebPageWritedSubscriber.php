<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\DomainEvent;

use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class WebPageWritedSubscriber
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageWritedSubscriber implements EventSubscriberInterface
{
    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return [
            'web_page.writed' => [
                'onWebPageWrited', 0
            ]
        ];
    }

    /**
     * @param WebPageWritedEvent $event
     */
    public function onWebPageWrited(WebPageWritedEvent $event)
    {
        $this->logger->info($event->execute());
    }
} 