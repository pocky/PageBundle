<?php

namespace spec\Black\Bundle\PageBundle\Application\Specification;

use Black\Bundle\PageBundle\Domain\Mongo\WebPage;
use Black\Bundle\PageBundle\Domain\Mongo\WebPageId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PageIsPublishedSpecificationSpec extends ObjectBehavior
{
    /**
     * @var
     */
    protected $page;

    /**
     *
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('Black\Bundle\PageBundle\Application\Specification\PageIsPublishedSpecification');
        $this->shouldImplement('Black\DDD\DDDinPHP\Application\Specification\SpecificationInterface');
    }

    /**
     *
     */
    function let()
    {
        $pageId = new WebPageId('12345');
        $page   = new WebPage($pageId, 'test');

        $this->page = $page;
    }

    /**
     *
     */
    function it_should_satisfied()
    {
        $this->page->publish(new \DateTime());

        $this->isSatisfiedBy($this->page)->shouldReturn(true);
    }
}
