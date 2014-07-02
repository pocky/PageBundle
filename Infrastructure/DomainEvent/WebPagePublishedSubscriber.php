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
 * Class WebPagePublishedSubscriber
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPagePublishedSubscriber implements EventSubscriberInterface
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
            'web_page.published' => [
                'onWebPagePublished', 0
            ]
        ];
    }

    /**
     * @param WebPagePublishedEvent $event
     */
    public function onWebPagePublished(WebPagePublishedEvent $event)
    {
        $this->logger->info($event->execute());
    }
} 