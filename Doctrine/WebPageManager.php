<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Doctrine;

use Black\Bundle\PageBundle\Model\WebPageManagerInterface;
use Black\Bundle\CommonBundle\Doctrine\ManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class PageManager
 *
 * @package Black\Bundle\PageBundle\Doctrine
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageManager implements WebPageManagerInterface, ManagerInterface
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
        $this->manager    = $dm;
        $this->repository = $dm->getRepository($class);
        $metadata         = $dm->getClassMetadata($class);
        $this->class      = $metadata->name;
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
     * @return mixed
     */
    public function findDocuments()
    {
        return $this->repository->findAll();
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function findDocument($value)
    {
        return $this->getRepository()->getWebPageByIdOrSlug($value);
    }

    /**
     * @param $text
     *
     * @return mixed
     */
    public function findWebPage($text)
    {
        return $this->getRepository()->searchWebPage($text);
    }

    /**
     * @param string $slug
     * 
     * @return Page
     */
    public function findWebPageBySlug($slug)
    {
        return $this->getRepository()->getWebPageBySlug($slug);
    }

    /**
     * @param integer $id
     * 
     * @return Page
     */
    public function findWebPageById($id)
    {
        return $this->getRepository()->getWebPageByid($id);
    }

    /**
     * @return array
     */
    public function findDraftPages()
    {
        return $this->getRepository()->getWebPagesByStatus('draft');
    }

    /**
     * @return array
     */
    public function findPublishedPages()
    {
        return $this->getRepository()->getWebPagesByStatus('publish');
    }

    /**
     * @param integer $limit
     * 
     * @return array
     */
    public function findLastPublishedPages($limit = 3)
    {
        return $this->getRepository()->getWebPages('publish', $limit);
    }

    /**
     * @param integer $limit
     * 
     * @return array
     */
    public function findLastDraftPages($limit = 3)
    {
        return $this->getRepository()->getWebPages('draft', $limit);
    }

    /**
     * @param $author
     *
     * @return mixed
     */
    public function findWebPagesByAuthor($author)
    {
        return $this->getRepository()->getWebPagesByAuthor($author);
    }

    /**
     * @return string
     */
    protected function getClass()
    {
        return $this->class;
    }
}
