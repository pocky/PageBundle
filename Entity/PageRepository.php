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
use Doctrine\ORM\NoResultException;

/**
 * PageRepository
 */
class PageRepository extends EntityRepository
{
    /**
     * @param string $slug
     * 
     * @return Page
     */
    public function getPageBySlug($slug)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.slug LIKE :slug')
                ->setParameter('slug', $slug)
                ->getQuery();

        try {
            $page = $qb->getSingleResult();
        } catch (NoResultException $e) {
            throw new EntityNotFoundException(
                sprintf('Unable to find an page object identified by "%s".', $slug)
            );
        }
        return $page;
    }

    /**
     * @param integer $id
     * 
     * @return page
     */
    public function getPageById($id)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery();

        try {
            $page = $qb->getSingleResult();
        } catch (EntityNotFoundException $e) {
            throw new EntityNotFoundException(
                sprintf('Unable to find an page object identified by "%s".', $id)
            );
        }
        return $page;
    }

    /**
     * @param string $status
     * 
     * @return array
     */
    public function getPagesByStatus($status)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.status LIKE :status')
                ->orderBy('p.updatedAt', 'desc')
                ->setParameter('status', $status)
                ->getQuery();

        return $qb->execute();
    }

    /**
     * @param string  $status
     * @param integer $limit
     * 
     * @return array
     */
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


    protected function getQueryBuilder($alias = 'p')
    {
        return $this->createQueryBuilder($alias);
    }
}
