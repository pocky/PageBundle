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
use Black\Bundle\PageBundle\Domain\Mongo\WebPageId;
use Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface;
use Black\DDD\DDDinPHP\Infrastructure\Service\InfrastructureServiceInterface;
use Black\Bundle\PageBundle\Application\DTO\WebPageDTO;
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
     * @param $id
     *
     * @return WebPageDTO
     * @throws \Black\Bundle\PageBundle\Domain\Exception\WebPageNotFoundException
     */
    public function read($id)
    {
        $id = new WebPageId($id);
        $page = $this->manager->find($id);

        if (null === $page) {
            throw new WebPageNotFoundException();
        }

        return $page;
    }
} 