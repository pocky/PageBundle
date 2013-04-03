<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Document;

use Doctrine\ODM\MongoDB\DocumentManager;

class PageManager extends DocumentManager
{
    protected $dm;
    protected $repository;
    protected $class;

    public function __construct(DocumentManager $dm, $class)
    {
        $this->dm           = $dm;
        $this->repository   = $dm->getRepository($class);

        $metada         = $dm->getClassMetadata($class);
        $this->class    = $metada->name;
    }

    public function persist($document)
    {
        if (!is_object($document)) {
            throw new \InvalidArgumentException(gettype($document));
        }

        $this->dm->persist($document);
    }

    public function remove($document)
    {
        if (!is_object($document)) {
            throw new \InvalidArgumentException(gettype($document));
        }

        $this->dm->remove($document);
    }

    public function flush()
    {
        $this->dm->flush();
    }

    public function getDocumentManager()
    {
        return $this->dm;
    }

    public function getDocumentRepository()
    {
        return $this->repository;
    }

    public function findPageBySlug($slug)
    {
        return $this->repository->getPageBySlug($slug);
    }

    public function findPageById($id)
    {
        return $this->repository->getPageByid($id);
    }

    public function findDraftPages()
    {
        return $this->repository->getPagesByStatus('draft');
    }

    public function findPublishedPages()
    {
        return $this->repository->getPagesByStatus('publish');
    }

    public function findLastPublishedPages($limit = 3)
    {
        return $this->repository->getPages('publish', $limit);
    }

    public function findLastDraftPages($limit = 3)
    {
        return $this->repository->getPages('draft', $limit);
    }

    /**
     * Create a new Page Object
     *
     * @return $page object
     */
    public function createPage()
    {
        $class  = $this->getClass();
        $page   = new $class;

        return $page;
    }

    protected function getClass()
    {
        return $this->class;
    }
}
