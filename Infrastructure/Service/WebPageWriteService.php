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
use Black\Bundle\PageBundle\Domain\Model\WebPageId;
use Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface;
use Black\DDD\DDDinPHP\Infrastructure\Service\InfrastructureServiceInterface;

class WebPageWriteService implements InfrastructureServiceInterface
{
    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface
     */
    protected $manager;

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
    public function create(WebPageId $webPageId, $author, $name)
    {
        $webPage = $this->manager->createWebPage($webPageId, $author, $name);

        $this->manager->add($webPage);

        return $webPage;
    }

    /**
     * @param $webPageId
     * @param $headline
     * @param $about
     * @param $text
     *
     * @return mixed
     * @throws \Black\Bundle\PageBundle\Domain\Exception\WebPageNotFoundException
     */
    public function write(WebPageId $webPageId, $headline, $about, $text)
    {
        $webPage = $this->manager->find($webPageId);

        if (null === $webPage) {
            throw new WebPageNotFoundException();
        }

        $webPage->write($headline, $about, $text);
        $this->manager->add($webPage);

        return $webPage;
    }

    /**
     * @param $webPageId
     * @param string $dateTime
     *
     * @return mixed
     * @throws \Black\Bundle\PageBundle\Domain\Exception\WebPageNotFoundException
     */
    public function publish(WebPageId $webPageId, $dateTime = 'now')
    {
        $webPage = $this->manager->find($webPageId);

        if (null === $webPage) {
            throw new WebPageNotFoundException();
        }

        if ('now' === $dateTime) {
            $dateTime = new \DateTime();
        }

        $webPage->publish($dateTime);
        $this->manager->add($webPage);

        return $webPage;
    }

    /**
     * @param $webPageId
     *
     * @return mixed
     * @throws \Black\Bundle\PageBundle\Domain\Exception\WebPageNotFoundException
     */
    public function depublish(WebPageId $webPageId)
    {
        $webPage = $this->manager->find($webPageId);

        if (null === $webPage) {
            throw new WebPageNotFoundException();
        }

        $webPage->depublish();
        $this->manager->add($webPage);

        return $webPage;
    }

    /**
     * @param $webPageId
     *
     * @return mixed
     * @throws \Black\Bundle\PageBundle\Domain\Exception\WebPageNotFoundException
     */
    public function remove(WebPageId $webPageId)
    {
        $webPage = $this->manager->find($webPageId);

        if (null === $webPage) {
            throw new WebPageNotFoundException();
        }

        $this->manager->remove($webPage);

        return $webPage;
    }
} 