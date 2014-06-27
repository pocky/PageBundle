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

use Black\Bundle\PageBundle\Domain\Entity\WebPageId;
use Doctrine\ORM\EntityRepository;

/**
 * Class WebPageEntityRepository
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageEntityRepository extends EntityRepository implements WebPageRepositoryInferface
{
    public function findWebPageByWebPageId(WebPageId $id)
    {
        $query = $this->getQueryBuilder()
            ->where('p.webPageId.value = :id')
            ->setParameter('id', $id->getValue())
            ->getQuery();

        return $query->getSingleResult();
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
