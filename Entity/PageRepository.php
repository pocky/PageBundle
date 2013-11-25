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

use Black\Bundle\PageBundle\Model\PageRepositoryInferface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NoResultException;

/**
 * Class PageRepository
 *
 * @package Black\Bundle\PageBundle\Entity
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageRepository extends EntityRepository implements PageRepositoryInferface
{
    /**
     * @param $slug
     *
     * @return mixed
     * @throws \Doctrine\ORM\EntityNotFoundException
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
     * @param $id
     *
     * @return mixed
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getPageById($id)
    {
        $qb = $this->getQueryBuilder('p')
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery();

        try {
            $page = $qb->getResult();
        } catch (EntityNotFoundException $e) {
            throw new EntityNotFoundException(
                sprintf('Unable to find an page object identified by "%s".', $id)
            );
        }
        return $page;
    }

    /**
     * @param $status
     *
     * @return mixed
     */
    public function getPagesByStatus($status)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.status = :status')
                ->orderBy('p.updatedAt', 'desc')
                ->setParameter('status', $status)
                ->getQuery();

        return $qb->execute();
    }

    /**
     * @param $author
     *
     * @return mixed
     */
    public function getPagesByAuthor($author)
    {
        $qb = $this->getQueryBuilder()
            ->where('p.author = :author')
            ->orderBy('p.updatedAt', 'desc')
            ->setParameter('author', $author)
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
                ->where('p.status = :status')
                ->orderBy('p.updatedAt', 'desc')
                ->setParameter('status', $status);

        if ($limit) {
            $qb = $qb->setMaxResults($limit);
        }

        $qb = $qb->getQuery();

        return $qb->execute();
    }

    /**
     * @param $text
     *
     * @return mixed
     */
    public function searchPage($text)
    {
        $qb = $this->getQueryBuilder();

        $qb = $qb
            ->where($qb->expr()->orX(
                $qb->expr()->like('name', 'text'),
                $qb->expr()->like('text', 'text'),
                $qb->expr()->like('description', 'text')
            ))
            ->setParameter('text', '%' . $text . '%')
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param string $alias
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function getQueryBuilder($alias = 'p')
    {
        return $this->createQueryBuilder($alias);
    }

    public function countPages(){
        $qb = $this->getQueryBuilder()
            ->select('count(p)')
            ->getQuery();

            try {
            $page = $qb->getSingleScalarResult();
        } catch (NoResultException $e) {
            throw new EntityNotFoundException(
                sprintf('No pages founded')
            );
        }

        return $page;
    }
}
