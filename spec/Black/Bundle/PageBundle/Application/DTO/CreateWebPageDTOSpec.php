<?php

namespace spec\Black\Bundle\PageBundle\Application\DTO;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateWebPageDTOSpec extends ObjectBehavior
{
    /**
     * @var
     */
    protected $id;

    /**
     * @var
     */
    protected $author;

    /**
     * @var
     */
    protected $name;

    function let()
    {
        $this->id       = 1;
        $this->author   = 'test';
        $this->name     = 'test';

        $this->beConstructedWith($this->id, $this->author, $this->name);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Black\Bundle\PageBundle\Application\DTO\CreateWebPageDTO');
        $this->shouldImplement('Black\DDD\DDDinPHP\Application\DTO\DTOInterface');
    }

    function it_should_return_id()
    {
        $this->getId()->shouldReturn($this->id);
    }

    function it_should_return_author()
    {
        $this->getAuthor()->shouldReturn($this->author);
    }

    function it_should_return_name()
    {
        $this->getName()->shouldReturn($this->name);
    }

    function it_should_return_context()
    {
        $this->getContext()->shouldReturn("http://schema.org");
    }

    function it_should_return_type()
    {
        $this->getType()->shouldReturn("WebPage");
    }

    function it_should_serialize()
    {
        $this->serialize()->shouldBeString();
    }

    function it_should_unserialize()
    {
        $serialized = $this->serialize();

        $object = $this->unserialize($serialized);
        $object->shouldBeArray();
    }
}
