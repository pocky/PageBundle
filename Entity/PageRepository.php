<?php

/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PageBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityNotFoundException;

class PageRepository extends EntityRepository
{
    public function getPageBySlug($slug)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.slug LIKE :slug')
                ->setParameter('slug', $slug)
                ->getQuery();

        return $qb->getSingleResult();
    }

    public function getPageById($id)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery();

        return $qb->getSingleResult();
    }

    public function getPagesByStatus($status)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.status LIKE :status')
                ->orderBy('p.updatedAt', 'desc')
                ->setParameter('status', $status)
                ->getQuery();

        return $qb->execute();
    }

    public function getPages($status, $limit = null)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.status LIKE :status')
                ->orderBy('p.updatedAt', 'desc')
                ->setParameter('status', $status);

        if ($limit) {
            $qb = $qb->limit($limit);
        }
        
        $qb = $this->getQuery();
        
        return $qb->execute();
    }

    private function getQueryBuilder()
    {
        return $this->createQueryBuilder('p');
    }
}
