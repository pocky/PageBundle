<?php

/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Blackroom\Bundle\PageBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentNotFoundException;

class PageRepository extends DocumentRepository
{
    public function getPageBySlug($slug)
    {
        $qb = $this->getQueryBuilder()
            ->field('slug')->equals($slug)
            ->getQuery();

        return $qb->getSingleResult();
    }

    public function getPageById($id)
    {
        $qb = $this->getQueryBuilder()
            ->field('id')->equals($id)
            ->getQuery();

        return $qb->getSingleResult();
    }

    public function getPagesByStatus($status)
    {
        $qb = $this->getQueryBuilder()
            ->field('status')->equals($status)
            ->sort('updatedAt', 'desc')
            ->getQuery();

        return $qb->execute();
    }

    public function getPages($status, $limit = null)
    {
        $qb = $this->getQueryBuilder()
            ->field('status')->equals($status)
            ->sort('updatedAt', 'desc')
            ->getQuery();

        if ($limit) {
            $qb = $qb->limit($limit);
        }

        return $qb->execute();
    }

    private function getQueryBuilder()
    {
        return $this->createQueryBuilder();
    }
}
