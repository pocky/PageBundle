<?php

namespace spec\Black\Bundle\PageBundle\Application\Specification;

use Black\Bundle\PageBundle\Domain\Mongo\WebPage;
use Black\Bundle\PageBundle\Domain\Mongo\WebPageId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rhumsaa\Uuid\Uuid;

class PageIsPublishedSpecificationSpec extends ObjectBehavior
{
    /**
     *
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('Black\Bundle\PageBundle\Application\Specification\PageIsPublishedSpecification');
    }
}
