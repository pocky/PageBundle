<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Domain\Document;

use Black\Bundle\PageBundle\Domain\Model\WebPageRepositoryInferface;
use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class WebPageRepository
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageRepository extends DocumentRepository implements WebPageRepositoryInferface
{
    /**
     * @param $key
     *
     * @return array|null|object
     * @throws \UnexpectedValueException
     * @throws \BadMethodCallException
     */
    public function getWebPageByIdOrSlug($key)
    {
        $qb = $this->getQueryBuilder();

        $qb = $qb
            ->addOr($qb->expr()->field('id')->equals($key))
            ->addOr($qb->expr()->field('slug')->equals($key))
            ->getQuery();

        return $qb->getSingleResult();
    }

    /**
     * @param $slug
     *
     * @return array|mixed|null|object
     * @throws \UnexpectedValueException
     * @throws \BadMethodCallException
     */
    public function getWebPageBySlug($slug)
    {
        $qb = $this->getQueryBuilder()
            ->field('slug')->equals($slug)
            ->getQuery();

        return $qb->getSingleResult();
    }

    /**
     * @param $id
     *
     * @return array|mixed|null|object
     * @throws \UnexpectedValueException
     * @throws \BadMethodCallException
     */
    public function getWebPageById($id)
    {
        $qb = $this->getQueryBuilder()
            ->field('id')->equals($id)
            ->getQuery();

        return $qb->getSingleResult();
    }

    /**
     * @param $status
     *
     * @return mixed
     * @throws \Doctrine\MongoDB\Exception\ResultException
     * @throws \Exception
     */
    public function getWebPagesByStatus($status)
    {
        $qb = $this->getQueryBuilder()
            ->field('status')->equals($status)
            ->sort('updatedAt', 'desc')
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param      $status
     * @param null $limit
     *
     * @return mixed
     * @throws \Doctrine\MongoDB\Exception\ResultException
     * @throws \Exception
     */
    public function getWebPages($status, $limit = null)
    {
        $qb = $this->getQueryBuilder()
            ->field('status')->equals($status)
            ->sort('updatedAt', 'desc');

        if ($limit) {
            $qb = $qb->limit($limit);
        }

        $qb = $qb->getQuery();

        return $qb->execute();
    }

    /**
     * @param $text
     *
     * @return mixed
     * @throws \Doctrine\MongoDB\Exception\ResultException
     * @throws \Exception
     */
    public function searchWebPage($text)
    {
        $text = new \MongoRegex('/' . $text . '/\i');

        $qb = $this->getQueryBuilder();
        $qb = $qb
            ->addOr($qb->expr()->field('name')->equals($text))
            ->addOr($qb->expr()->field('text')->equals($text))
            ->addOr($qb->expr()->field('description')->equals($text))
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param $author
     *
     * @return mixed
     * @throws \Doctrine\MongoDB\Exception\ResultException
     * @throws \Exception
     */
    public function getWebPagesByAuthor($author)
    {
        $qb = $this->getQueryBuilder()
            ->field('author')->equals($author)
            ->sort('updatedAt', 'desc')
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    protected function getQueryBuilder()
    {
        return $this->createQueryBuilder();
    }
}
