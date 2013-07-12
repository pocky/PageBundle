<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PageBundle\Entity;

use Black\Bundle\PageBundle\Model\ManagerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Class BaseManager
 */
class BaseManager extends EntityManager implements ManagerInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    public function __construct(EntityManager $dm, $class)
    {
        $this->manager     = $dm;
        $this->repository  = $dm->getRepository($class);

        $metadata          = $dm->getClassMetadata($class);
        $this->class       = $metadata->name;
    }

    /**
     * @return EntityManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @return \Doctrine\ODM\MongoDB\EntityRepository
     */
    public function getRepository($className = '')
    {
        return $this->repository;
    }

    /**
     * @param object $entity
     *
     * @throws \InvalidArgumentException
     */
    public function persist($entity)
    {
        if (!$entity instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($entity));
        }

        $this->getManager()->persist($entity);
    }

    /**
     *
     */
    public function flush()
    {
        $this->getManager()->flush();
    }

    /**
     * @param object $entity
     *
     * @throws \InvalidArgumentException
     */
    public function remove($entity)
    {
        if (!$entity instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($entity));
        }
        
        $this->getManager()->remove($entity);
    }

    /**
     * Save and Flush a new entity
     *
     * @param $entity
     */
    public function persistAndFlush($entity)
    {
        $this->persist($entity);
        $this->flush();
    }

    /**
     * @param $entity
     */
    public function removeAndFlush($entity)
    {
        $this->getManager()->remove($entity);
        $this->getManager()->flush();
    }

    /**
     * Create a new entity
     *
     * @return $config object
     */
    public function createInstance()
    {
        $class  = $this->getClass();
        $entity = new $class;

        return $entity;
    }

    /**
     * @return string
     */
    protected function getClass()
    {
        return $this->class;
    }
}
