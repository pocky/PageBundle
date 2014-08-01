<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\Service;

use Black\Bundle\PageBundle\Domain\Exception\WebPageNotFoundException;
use Black\Bundle\PageBundle\Domain\Model\WebPageId;
use Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface;
use Black\DDD\DDDinPHP\Infrastructure\Service\InfrastructureServiceInterface;
use Black\DDD\DDDinPHP\Application\Specification\SpecificationInterface;

class WebPageReadService implements InfrastructureServiceInterface
{
    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface
     */
    protected $manager;

    /**
     * @param WebPageManagerInterface $manager
     * @param SpecificationInterface $specification
     */
    public function __construct(
        WebPageManagerInterface $manager,
        SpecificationInterface $specification
    ) {
        $this->manager       = $manager;
        $this->specification = $specification;
    }

    /**
     * @param WebPageId $webPageId
     *
     * @return mixed
     * @throws \Black\Bundle\PageBundle\Domain\Exception\WebPageNotFoundException
     */
    public function read(WebPageId $webPageId)
    {
        $page = $this->manager->find($webPageId);

        if (null === $page) {
            throw new WebPageNotFoundException();
        }

        return $page;
    }
} 