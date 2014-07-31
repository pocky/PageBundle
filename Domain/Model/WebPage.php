<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class WebPage
 *
 * A web page. Every web page is implicitly assumed to be declared to be of type WebPage.
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class WebPage implements WebPageInterface
{
    /**
     * @var
     */
    protected $webPageId;

    /**
     * The name of the WebPage
     *
     */
    protected $name;

    /**
     * The slug of the WebPage
     *
     */
    protected $slug;

    /**
     * Headline of the WebPage
     *
     */
    protected $headline;

    /**
     * The subject matter of the content.
     *
     */
    protected $about;

    /**
     * The textual content of the WebPage
     *
     */
    protected $text;


    /**
     * The date on which the WebPage was created
     *
     */
    protected $dateCreated;

    /**
     * The date on which the WebPage was most recently modified
     *
     */
    protected $dateModified;

    /**
     * Date of first broadcast/publication
     *
     */
    protected $datePublished;

    /**
     * Construct the WebPage
     */
    public function __construct(WebPageId $id, $name)
    {
        $this->webPageId     = $id;
        $this->name          = $name;
        $this->dateCreated   = new \DateTime();
        $this->dateModified  = new \DateTime();
    }

    /**
     * @return WebPageId
     */
    public function getWebPageId()
    {
        return $this->webPageId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * @return mixed
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return mixed
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @return mixed
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->datePublished ? true : false;
    }

    /**
     * @param $headline
     * @param $about
     * @param $text
     */
    public function write($headline, $about, $text)
    {
        $this->headline     = $headline;
        $this->about        = $about;
        $this->text         = $text;
        $this->dateModified = new \DateTime();
    }

    /**
     * @param \DateTime $dateTime
     */
    public function publish(\DateTime $dateTime)
    {
        $this->datePublished = $dateTime;
    }

    /**
     *
     */
    public function depublish()
    {
        $this->datePublished = null;
    }

    /**
     * @param $name
     * @param $headline
     * @param $about
     * @param $text
     */
    public function edit($name, $headline, $about, $text)
    {
        $this->name         = $name;
        $this->headline     = $headline;
        $this->about        = $about;
        $this->text         = $text;
        $this->dateModified = new \DateTime();
    }
}
