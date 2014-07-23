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


    function let($id = 1, $name = 'test', $headline = 'test', $about = 'test', $text = 'test')
    {
        $this->id = $id;
        $this->name = $name;
        $this->headline = $headline;
        $this->about = $about;
        $this->text = $text;

        $this->beConstructedWith($this->id, $this->name, $this->headline, $this->about, $this->text);

    }

    /**
     *
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('Black\Bundle\PageBundle\Application\DTO\WebPageDTO');
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
