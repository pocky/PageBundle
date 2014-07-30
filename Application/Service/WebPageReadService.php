<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\Service;

use Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface;
use Black\DDD\DDDinPHP\Application\Service\ApplicationServiceInterface;
use Black\Bundle\PageBundle\Application\DTO\WebPageDTO;
use Black\DDD\DDDinPHP\Application\Specification\SpecificationInterface;
use Black\DDD\DDDinPHP\Infrastructure\Service\InfrastructureServiceInterface;

class WebPageReadService implements ApplicationServiceInterface
{
    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface
     */
    protected $manager;

    /**
     * @var \Black\DDD\DDDinPHP\Application\Specification\SpecificationInterface
     */
    protected $specification;

    /**
     * @var \Black\DDD\DDDinPHP\Infrastructure\Service\InfrastructureServiceInterface
     */
    protected $service;

    /**
     * @param WebPageManagerInterface $manager
     * @param SpecificationInterface $specification
     * @param InfrastructureServiceInterface $service
     */
    public function __construct(
        WebPageManagerInterface $manager,
        SpecificationInterface $specification,
        InfrastructureServiceInterface $service
    ) {
        $this->manager       = $manager;
        $this->specification = $specification;
        $this->service       = $service;
    }

    /**
     * @param $id
     *
     * @return WebPageDTO
     */
    public function read($id)
    {
        $page = $this->service->read($id);

        if ($this->specification->isSatisfiedBy($page)) {

            $dto = new WebPageDTO(
                $page->getWebPageId()->getValue(),
                $page->getName(),
                $page->getHeadline(),
                $page->getAbout(),
                $page->getText()
            );

            return $dto;
        }
    }
} 