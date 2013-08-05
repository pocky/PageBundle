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

use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentNotFoundException;

/**
 * Class PageRepository
 *
 * @package Black\Bundle\PageBundle\Document
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageRepository extends DocumentRepository
{
    /**
     * @param $slug
     *
     * @return object
     * @throws \Doctrine\ODM\MongoDB\DocumentNotFoundException
     */
    public function getPageBySlug($slug)
    {
        $qb = $this->getQueryBuilder()
            ->field('slug')->equals($slug)
            ->getQuery();

        try {
            $page = $qb->getSingleResult();
        } catch (DocumentNotFoundException $e) {
            throw new DocumentNotFoundException(
                sprintf('Unable to find an page object identified by "%s".', $slug)
            );
        }
        return $page;
    }

    /**
     * @param $id
     * @return object
     * @throws \Doctrine\ODM\MongoDB\DocumentNotFoundException
     */
    public function getPageById($id)
    {
        $qb = $this->getQueryBuilder()
            ->field('id')->equals($id)
            ->getQuery();

        try {
            $page = $qb->getSingleResult();
        } catch (NoResultException $e) {
            throw new DocumentNotFoundException(
                sprintf('Unable to find an page object identified by "%s".', $id)
            );
        }
        return $page;
    }

    /**
     * @param $status
     * @return array|bool|\Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|null
     */
    public function getPagesByStatus($status)
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
     * @return array|bool|\Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|null
     */
    public function getPages($status, $limit = null)
    {
        $qb = $this->getQueryBuilder()
            ->field('status')->equals($status)
            ->sort('updatedAt', 'desc')
        ;

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
     */
    public function searchPage($text)
    {
        $text = new \MongoRegex('/' . $text . '/\i');

        $qb = $this->getQueryBuilder();
        $qb = $qb
            ->addOr($qb->expr()->field('name')->equals($text))
            ->addOr($qb->expr()->field('text')->equals($text))
            ->addOr($qb->expr()->field('description')->equals($text))
            ->getQuery()
        ;

        return $qb->execute();
    }

    /**
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    private function getQueryBuilder()
    {
        return $this->createQueryBuilder();
    }
}
