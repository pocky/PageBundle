<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\Persistence;

use Doctrine\ORM\EntityRepository;

/**
 * Class WebPageEntityRepository
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageEntityRepository extends EntityRepository implements WebPageRepositoryInferface
{
    /**
     * @param $key
     *
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getWebPageByIdOrSlug($key)
    {
        $qb = $this->getQueryBuilder();

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
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getWebPageBySlug($slug)
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
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getWebPageById($id)
    {
        $qb = $this->getQueryBuilder('p')
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery();

        return $qb->getSingleResult();
    }

    /**
     * @param $status
     *
     * @return mixed
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function getWebPagesByStatus($status)
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
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function getWebPagesByAuthor($author)
    {
        $qb = $this->getQueryBuilder()
            ->where('p.author = :author')
            ->orderBy('p.updatedAt', 'desc')
            ->setParameter('author', $author)
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param      $status
     * @param null $limit
     *
     * @return mixed
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function getWebPages($status, $limit = null)
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
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function searchWebPage($text)
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
     * @throws \InvalidArgumentException
     */
    protected function getQueryBuilder($alias = 'p')
    {
        return $this->createQueryBuilder($alias);
    }
}
