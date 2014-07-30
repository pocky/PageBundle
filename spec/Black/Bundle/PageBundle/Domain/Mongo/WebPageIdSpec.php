<?php

namespace spec\Black\Bundle\PageBundle\Domain\Mongo;

use Black\Bundle\PageBundle\Domain\Mongo\WebPageId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WebPageIdSpec extends ObjectBehavior
{
    /**
     * @var
     */
    protected $id;

    /**
     *
     */
    function let()
    {
        $pageId = new WebPageId('12345');

        $this->id = $pageId;
        $this->beConstructedWith($pageId->getValue());
    }

    /**
     *
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('Black\Bundle\PageBundle\Domain\Mongo\WebPageId');
        $this->shouldImplement('Black\Bundle\PageBundle\Domain\Model\WebPageid');
    }

    function it_should_have_a_value()
    {
        $this->getValue()->shouldBeEqualTo('12345');
    }

    function it_sould_have_a_toString()
    {
        $this->__toString()->shouldBeEqualTo('12345');
    }

    function it_should_be_equal()
    {
        $object2 = new WebPageId('12345');

        $this->isEqualTo($object2)->shouldReturn(true);
    }

    function it_should_not_be_equal()
    {
        $object2 = new WebPageId('1');

        $this->isEqualTo($object2)->shouldReturn(false);
    }
}
