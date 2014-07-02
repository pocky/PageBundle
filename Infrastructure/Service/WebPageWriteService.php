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


use Black\Bundle\PageBundle\Domain\Exception\WebPageNotFoundException;
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
    public function create($name)
    {
        $pageId  = new WebPageId(Uuid::uuid4());
        $webPage = $this->manager->createInstance($pageId, $name);

        $this->manager->add($webPage);

        return $webPage;
    }

    /**
     * @param $webPageId
     * @param $headline
     * @param $about
     * @param $text
     *
     * @return WebPageNotFoundException
     */
    public function write($webPageId, $headline, $about, $text)
    {
        $pageId  = new WebPageId($webPageId);
        $webPage = $this->manager->find($pageId);

        if (!$webPage) {
            return new WebPageNotFoundException();
        }

        $webPage->write($headline, $about, $text);
        $this->manager->add($webPage);

        return $webPage;
    }

    /**
     * @param $webPageId
     * @param string $dateTime
     *
     * @return WebPageNotFoundException
     */
    public function publish($webPageId, $dateTime = 'now')
    {
        $pageId  = new WebPageId($webPageId);
        $webPage = $this->manager->find($pageId);

        if (!$webPage) {
            return new WebPageNotFoundException();
        }

        if ('now' === $dateTime) {
            $dateTime = new \DateTime();
        }

        $webPage->publish($dateTime);
        $this->manager->add($webPage);

        return $webPage;
    }
} 