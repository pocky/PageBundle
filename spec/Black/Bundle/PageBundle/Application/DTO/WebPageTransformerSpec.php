<?php

namespace spec\Black\Bundle\PageBundle\Application\DTO;

use Black\Bundle\PageBundle\Domain\Model\WebPageId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WebPageTransformerSpec extends ObjectBehavior
{
    protected $entityClass;

    protected $dtoClass;

    function let()
    {
        $this->entityClass = 'Black\Bundle\PageBundle\Domain\Model\WebPage';
        $this->dtoClass    = 'Black\Bundle\PageBundle\Application\DTO\WebPageDTO';

        $this->beConstructedWith($this->entityClass, $this->dtoClass);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Black\Bundle\PageBundle\Application\DTO\WebPageTransformer');
    }

    function it_should_transform()
    {
        $entity = new $this->entityClass(new WebPageId(1), 'test', 'test');
        $this->transform($entity)->shouldReturnAnInstanceOf($this->dtoClass);
    }

    function it_should_reverseTransform()
    {
        $dto = new $this->dtoClass(1, 'test', 'test');
        $this->reverseTransform($dto)->shouldReturnAnInstanceOf($this->entityClass);
    }
}
