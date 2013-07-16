<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Doctrine;

use Black\Bundle\PageBundle\Model\PageManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * PageManager
 */
class PageManager implements PageManagerInterface
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor
     *
     * @param ObjectManager $dm
     * @param string        $class
     */
    public function __construct(ObjectManager $dm, $class)
    {
        $this->manager     = $dm;
        $this->repository  = $dm->getRepository($class);

        $metadata          = $dm->getClassMetadata($class);
        $this->class       = $metadata->name;
    }

    /**
     * @return ObjectManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param object $model
     *
     * @throws \InvalidArgumentException
     */
    public function persist($model)
    {
        if (!$model instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($model));
        }

        $this->getManager()->persist($model);
    }

    /**
     * Flush
     */
    public function flush()
    {
        $this->getManager()->flush();
    }

    /**
     * Remove the model
     * 
     * @param object $model
     *
     * @throws \InvalidArgumentException
     */
    public function remove($model)
    {
        if (!$model instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($model));
        }
        $this->getManager()->remove($model);
    }

    /**
     * Save and Flush a new model
     *
     * @param mixed $model
     */
    public function persistAndFlush($model)
    {
        $this->persist($model);
        $this->flush();
    }

    /**
     * Remove and flush
     * 
     * @param mixed $model
     */
    public function removeAndFlush($model)
    {
        $this->getManager()->remove($model);
        $this->getManager()->flush();
    }

    /**
     * Create a new model
     *
     * @return $config object
     */
    public function createInstance()
    {
        $class  = $this->getClass();
        $model = new $class;

        return $model;
    }

    /**
     * @return string
     */
    protected function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $slug
     * 
     * @return Page
     */
    public function findPageBySlug($slug)
    {
        return $this->getRepository()->getPageBySlug($slug);
    }

    /**
     * @param integer $id
     * 
     * @return Page
     */
    public function findPageById($id)
    {
        return $this->getRepository()->getPageByid($id);
    }

    /**
     * @return array
     */
    public function findDraftPages()
    {
        return $this->getRepository()->getPagesByStatus('draft');
    }

    /**
     * @return array
     */
    public function findPublishedPages()
    {
        return $this->getRepository()->getPagesByStatus('publish');
    }

    /**
     * @param integer $limit
     * 
     * @return array
     */
    public function findLastPublishedPages($limit = 3)
    {
        return $this->getRepository()->getPages('publish', $limit);
    }

    /**
     * @param integer $limit
     * 
     * @return array
     */
    public function findLastDraftPages($limit = 3)
    {
        return $this->getRepository()->getPages('draft', $limit);
    }
}
