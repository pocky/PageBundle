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
     * @param $key
     *
     * @return mixed
     */
    public function getPageByIdOrSlug($key)
    {
        $qb     = $this->getQueryBuilder();

        $qb = $qb
            ->where('p.id = :key')
            ->orWhere('p.slug = :key')
            ->setParameter('key', $key)
            ->getQuery();

        return $qb->getSingleResult();
    }

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

        return $qb->getSingleResult();
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getPageById($id)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery();

        return $qb->getSingleResult();
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
}
