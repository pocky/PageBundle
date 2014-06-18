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

/**
 * Class WebPageManager
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageManager extends AbstractManager implements WebPageManagerInterface
{
    /**
     * @return mixed
     */
    public function createInstance(WebPageId $id, $name)
    {
        $class  = $this->getClass();
        $object = new $class($id, $name);

        return $object;
    }

    /**
     * @param WebPageId $id
     * @return mixed
     */
    public function find(WebPageId $id)
    {
        return $this->repository->findOneById($id);
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param $object
     * @throws \InvalidArgumentException
     */
    public function add($object)
    {
        if (!$object instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($object));
        }

        $this->manager->persist($object);
    }

    /**
     * @param $object
     * @throws \InvalidArgumentException
     */
    public function remove($object)
    {
        if (!$object instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($object));
        }

        $this->getManager()->remove($object);
    }
}
