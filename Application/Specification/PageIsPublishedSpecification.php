<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\Specification;

use Black\Bundle\PageBundle\Domain\Model\WebPageInterface;
use Black\DDD\DDDinPHP\Application\Specification\SpecificationInterface;

/**
 * Class PageIsPublishedSpecification
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageIsPublishedSpecification implements SpecificationInterface
{
    /**
     * @param WebPageInterface $page
     *
     * @return bool
     */
    public function isSatisfiedBy(WebPageInterface $page)
    {
        return $page->isPublished();
    }
}