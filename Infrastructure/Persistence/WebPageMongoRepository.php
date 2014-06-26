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

use Doctrine\ODM\MongoDB\DocumentRepository;
use MongoDBODMProxies\__CG__\Black\Bundle\PageBundle\Domain\Mongo\WebPageId;

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
            ->where('webPageId.value')->equals($id)
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
