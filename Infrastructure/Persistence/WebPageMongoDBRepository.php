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

use Black\Component\Page\Domain\Model\WebPageId;
use Black\Component\Page\Infrastructure\Persistence\WebPageRepository as WebPageRepositoryInferface;
use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class WebPageRepository
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageMongoRepository extends DocumentRepository implements WebPageRepositoryInferface
{
    public function findWebPageByWebPageId(WebPageId $id)
    {
        $query = $this->getQueryBuilder()
            ->field('webPageId.value')->equals($id->getValue())
            ->getQuery();

        return $query->getSingleResult();
    }

    /**
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    protected function getQueryBuilder()
    {
        return $this->createQueryBuilder();
    }
}