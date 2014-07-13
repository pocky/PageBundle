<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\Doctrine;

use Black\Bundle\CommonBundle\Infrastructure\Doctrine\AbstractManager;
use Black\Bundle\PageBundle\Domain\Model\WebPageId;
use Black\Bundle\PageBundle\Domain\Model\WebPageInterface;

/**
 * Class WebPageManager
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageManager extends AbstractManager implements WebPageManagerInterface
{
    /**
     * @param WebPageId $id
     * @param $name
     * @return mixed
     */
    public function createInstance(WebPageId $id, $name = 'Default name')
    {
        $class   = $this->getClass();
        $webPage = new $class($id, $name);

        return $webPage;
    }

    /**
     * @param WebPageId $id
     * @return mixed
     */
    public function find(WebPageId $id)
    {
        return $this->repository->findWebPageByWebPageId($id);
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param $webPage
     * @throws \InvalidArgumentException
     */
    public function add(WebPageInterface $webPage)
    {
        if (!$webPage instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($webPage));
        }

        $this->manager->persist($webPage);
    }

    /**
     * @param $webPage
     * @throws \InvalidArgumentException
     */
    public function remove(WebPageInterface $webPage)
    {
        if (!$webPage instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($webPage));
        }

        $this->getManager()->remove($webPage);
    }
}
