<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\DTO;

use Black\Bundle\PageBundle\Domain\Model\WebPageId;
use Black\Bundle\PageBundle\Domain\Model\WebPageInterface;

class WebPageTransformer
{
    /**
     * @var
     */
    protected $entityClass;

    /**
     * @var
     */
    protected $dtoClass;

    /**
     * @param $entityClass
     * @param $dtoClass
     */
    public function __construct($entityClass, $dtoClass)
    {
        $this->entityClass = $entityClass;
        $this->dtoClass    = $dtoClass;
    }

    /**
     * @param WebPageInterface $webPage
     * @return mixed
     */
    public function transform(WebPageInterface $webPage)
    {
        $this->verify($webPage, $this->entityClass);

        $dto = new $this->dtoClass(
            $webPage->getWebPageId()->getValue(),
            $webPage->getAuthor(),
            $webPage->getName(),
            $webPage->getHeadline(),
            $webPage->getAbout(),
            $webPage->getText()
        );

        return $dto;
    }

    /**
     * @param WebPageDTO $webPageDTO
     * @return mixed
     */
    public function reversetransform(WebPageDTO $webPageDTO)
    {
        $this->verify($webPageDTO, $this->dtoClass);

        $webPageId = new WebPageId($webPageDTO->getId());

        $webPage = new $this->entityClass(
            $webPageId,
            $webPageDTO->getName(),
            $webPageDTO->getAuthor(),
            $webPageDTO->getHeadline(),
            $webPageDTO->getAbout(),
            $webPageDTO->getText()
        );

        return $webPage;
    }

    /**
     * @param $object
     * @param $class
     *
     * @throws \Exception
     */
    protected function verify($object, $class)
    {
        if (!$object instanceof $class) {
            throw new \Exception();
        }
    }
} 