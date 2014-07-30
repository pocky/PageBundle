<?php

namespace spec\Black\Bundle\PageBundle\Domain\Entity;

use Black\Bundle\PageBundle\Domain\Entity\WebPage;
use Black\Bundle\PageBundle\Domain\Entity\WebPageId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WebPageSpec extends ObjectBehavior
{
    /**
     * @var
     */
    protected $webPageId;

    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $slug;

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

    /**
     * @var
     */
    protected $dateCreated;

    /**
     * @var
     */
    protected $dateModified;

    /**
     * @var
     */
    protected $datePublished;

    /**
     *
     */
    function let()
    {
        $pageId = new WebPageId('12345');
        $page   = new WebPage($pageId, 'test');

        $this->webPageId = $page->getWebPageId();
        $this->name      = $page->getName();

        $this->beConstructedWith($this->webPageId, $this->name);
    }

    /**
     *
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('Black\Bundle\PageBundle\Domain\Entity\WebPage');
        $this->shouldImplement('Black\Bundle\PageBundle\Domain\Model\WebPage');
    }

    function it_should_have_a_dateCreated()
    {
        $this->getDateCreated()->shouldHaveType('DateTime');
    }

    function it_should_have_a_dateModified()
    {
        $this->getDateCreated()->shouldHaveType('DateTime');
    }

    function it_should_not_be_published()
    {
        $this->shouldNotBePublished();
    }

    function it_should_be_write()
    {
        $this->headline = "headline";
        $this->about    = "about";
        $this->text     = "text";

        $this->write($this->headline, $this->about, $this->text);

        $this->getHeadline()->shouldReturn("headline");
        $this->getAbout()->shouldReturn("about");
        $this->getText()->shouldReturn("text");
    }

    function it_should_be_edited()
    {
        $this->headline = "headline 2";
        $this->about    = "about 2";
        $this->text     = "text 2";

        $this->write($this->headline, $this->about, $this->text);

        $this->getHeadline()->shouldReturn("headline 2");
        $this->getAbout()->shouldReturn("about 2");
        $this->getText()->shouldReturn("text 2");
    }

    function it_sould_be_published()
    {
        $this->publish(new \DateTime());

        $this->shouldBePublished();
    }

    function it_should_be_depublished()
    {
        $this->depublish();

        $this->shouldNotBePublished();
    }
}
