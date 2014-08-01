<?php

namespace spec\Black\Bundle\PageBundle\Application\DTO;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WebPageDTOSpec extends ObjectBehavior
{
    /**
     * @var
     */
    protected $id;

    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $headline;

    /**
     * @var
     */
    protected $about;

    /**
     * @var
     */
    protected $text;


    function let()
    {
        $this->id       = 1;
        $this->name     = 'test';
        $this->headline = 'test';
        $this->about    = 'test';
        $this->text     = 'test';

        $this->beConstructedWith($this->id, $this->name, $this->headline, $this->about, $this->text);
    }

    /**
     *
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('Black\Bundle\PageBundle\Application\DTO\WebPageDTO');
        $this->shouldImplement('Black\DDD\DDDinPHP\Application\DTO\DTOInterface');
    }

    /**
     *
     */
    function it_should_return_id()
    {
        $this->getId()->shouldReturn($this->id);
    }

    /**
     *
     */
    function it_should_return_name()
    {
        $this->getName()->shouldReturn($this->name);
    }

    /**
     *
     */
    function it_should_return_headline()
    {
        $this->getHeadline()->shouldReturn($this->headline);
    }

    /**
     *
     */
    function it_should_return_about()
    {
        $this->getAbout()->shouldReturn($this->about);
    }

    /**
     *
     */
    function it_should_return_text()
    {
        $this->getText()->shouldReturn($this->text);
    }

    /**
     *
     */
    function it_should_return_context()
    {
        $this->getContext()->shouldReturn("http://schema.org");
    }

    /**
     *
     */
    function it_sould_return_type()
    {
        $this->getType()->shouldReturn("WebPage");
    }

    /**
     *
     */
    function it_should_serialize()
    {
        $this->serialize()->shouldBeString();
    }

    /**
     *
     */
    function it_should_unserialize()
    {
        $serialized = $this->serialize();

        $object = $this->unserialize($serialized);
        $object->shouldBeArray();
    }
}
