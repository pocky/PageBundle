<?php

namespace Black\Bundle\PageBundle\Application\DTO;

use Black\Bundle\PageBundle\Domain\Model\WebPageId;
use Black\Bundle\PageBundle\Domain\Model\WebPageInterface;

class CreateWebPageTransformer
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
            $webPage->getName()
        );

        return $dto;
    }

    /**
     * @param CreateWebPageDTO $webPageDTO
     * @return mixed
     */
    public function reverseTransform(CreateWebPageDTO $webPageDTO)
    {
        $this->verify($webPageDTO, $this->dtoClass);

        $webPageId = new WebPageId($webPageDTO->getId());

        $webPage = new $this->entityClass(
            $webPageId,
            $webPageDTO->getName(),
            $webPageDTO->getAuthor()
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
