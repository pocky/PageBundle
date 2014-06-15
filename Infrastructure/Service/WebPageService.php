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


use Black\Bundle\PageBundle\Domain\Model\WebPageId;
use Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface;
use Black\DDD\DDDinPHP\Infrastructure\Service\ServiceInterface;

class WebPageService implements ServiceInterface
{
    /**
     * @param WebPageManagerInterface $webPageManager
     */
    public function __construct(WebPageManagerInterface $webPageManager)
    {
        $this->manager = $webPageManager;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function create($name)
    {
        $id      = new WebPageId(new \MongoId());
        $webPage = $this->manager->createInstance($id, $name);
        $webPage = $this->manager->persist($webPage);

        return $webPage;
    }
} 