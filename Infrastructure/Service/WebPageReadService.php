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
use Black\DDD\DDDinPHP\Infrastructure\Service\ServiceInterface;
use Black\Bundle\PageBundle\Application\DTO\WebPageDTO;

class WebPageReadService implements ServiceInterface
{
    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface
     */
    protected $manager;

    /**
     * @param WebPageManagerInterface $manager
     */
    public function __construct(WebPageManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param $id
     *
     * @return mixed
     *
     * @throws \Black\Bundle\PageBundle\Domain\Exception\WebPageNotFoundException
     */
    public function read($id)
    {
        $id = new WebPageId($id);
        $page = $this->manager->find($id);

        if ($page->getWebPageId()->isEqualTo($id)) {

            $dto = new WebPageDTO(
                $page->getWebPageId()->getValue(),
                $page->getName()
            );

            return $dto;
        }

        throw new WebPageNotFoundException();
    }
} 