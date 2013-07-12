<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PageBundle\Document;

use Black\Bundle\PageBundle\Model\ManagerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Configuration;

/**
 * Class BaseManager
 */
class BaseManager extends DocumentManager implements ManagerInterface
{
    /**
     * @var \Doctrine\ODM\MongoDB\DocumentManager
     */
    protected $manager;

    /**
     * @var \Doctrine\ODM\MongoDB\DocumentRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    public function __construct(DocumentManager $dm, $class)
    {
        $this->manager     = $dm;
        $this->repository  = $dm->getRepository($class);

        $metadata          = $dm->getClassMetadata($class);
        $this->class       = $metadata->name;
    }

    /**
     * @return DocumentManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @return \Doctrine\ODM\MongoDB\DocumentRepository
     */
    public function getRepository($className = '')
    {
        return $this->repository;
    }

    /**
     * @param object $document
     *
     * @throws \InvalidArgumentException
     */
    public function persist($document)
    {
        if (!$document instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($document));
        }

        $this->getManager()->persist($document);
    }

    /**
     *
     */
    public function flush()
    {
        $this->getManager()->flush();
    }

    /**
     * @param object $document
     *
     * @throws \InvalidArgumentException
     */
    public function remove($document)
    {
        if (!$document instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($document));
        }
        
        $this->getManager()->remove($document);
    }

    /**
     * Save and Flush a new document
     *
     * @param $document
     */
    public function persistAndFlush($document)
    {
        $this->persist($document);
        $this->flush();
    }

    /**
     * @param $document
     */
    public function removeAndFlush($document)
    {
        $this->getManager()->remove($document);
        $this->getManager()->flush();
    }

    /**
     * Create a new document
     *
     * @return $config object
     */
    public function createInstance()
    {
        $class  = $this->getClass();
        $document = new $class;

        return $document;
    }

    /**
     * @return string
     */
    protected function getClass()
    {
        return $this->class;
    }
}
