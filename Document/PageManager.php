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

use Black\Bundle\PageBundle\Model\PageManagerInterface;
use Black\Bundle\EngineBundle\Document\BaseManager;
use Doctrine\ODM\MongoDB\DocumentManager;

class PageManager extends BaseManager implements PageManagerInterface
{
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
}
