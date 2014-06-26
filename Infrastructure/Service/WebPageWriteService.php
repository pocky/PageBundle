<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\Service;


use Black\Bundle\PageBundle\Domain\Model\WebPageInterface;
use Black\Bundle\PageBundle\Domain\Mongo\WebPageId;
use Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface;
use Black\DDD\DDDinPHP\Infrastructure\Service\ServiceInterface;
use Rhumsaa\Uuid\Uuid;

class WebPageWriteService implements ServiceInterface
{
    /**
     * @param WebPageManagerInterface $webPageManager
     */
    public function __construct(WebPageManagerInterface $webPageManager)
    {
        $this->manager = $webPageManager;
    }

    /**
     * return mixed
     */
    public function create(WebPageManagerInterface $manager, $name)
    {
        $pageId  = new WebPageId(Uuid::uuid1());
        $webPage = $manager->createInstance($pageId, $name);
        $webPage = $manager->add($webPage);

        return $webPage;
    }

    /**
     * @param WebPageInterface $webPage
     * @param $dateTime
     */
    public function publish(WebPageInterface $webPage, $dateTime = 'now')
    {
        if ('now' === $dateTime) {
            $dateTime = new \DateTime();
        }

        $webPage->publish($dateTime);
    }
} 