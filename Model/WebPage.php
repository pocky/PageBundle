<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * A web page. Every web page is implicitly assumed to be declared to be of type WebPage.
 *
 * @package Black\Bundle\PageBundle\Model
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class WebPage implements WebPageInterface
{
    /**
     * @var
     */
    protected $id;

    /**
     * The name of the WebPage
     *
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     * @Assert\NotNull
     */
    protected $name;

    /**
     * The slug of the WebPage
     *
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     * @Gedmo\Slug(fields={"name"})
     */
    protected $slug;

    /**
     * Headline of the WebPage
     *
     * @Assert\Type(type="string")
     */
    protected $headline;

    /**
     * The textual content of the WebPage
     *
     * @Assert\Type(type="string")
     */
    protected $text;

    /**
     * The author of the WebPage
     */
    protected $author;

    /**
     * URL of an image of the WebPage
     *
     * @Assert\Image(maxSize="2M")
     */
    protected $image;

    /**
     * Publication of the page
     *
     * @Assert\Choice(callback="getPublicationStatus")
     * @Assert\NotNull
     */
    protected $publication;

    /**
     * The date on which the WebPage was created
     *
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="create")
     */
    protected $dateCreated;

    /**
     * The date on which the WebPage was most recently modified
     *
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="update")
     */
    protected $dateModified;

    /**
     * Date of first broadcast/publication
     *
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="create")
     */
    protected $datePublished;

    /**
     * Construct the WebPage
     */
    public function __construct()
    {
        $this->dateCreated   = new \DateTime();
        $this->dateModified  = new \DateTime();
        $this->datePublished = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param $author
     *
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     *
     * @return $this
     */
    public function setDateCreated(\DateTime $dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @param \DateTime $dateModified
     *
     * @return $this
     */
    public function setDateModified(\DateTime $dateModified)
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * @param \DateTime $datePublished
     *
     * @return $this
     */
    public function setDatePublished(\DateTime $datePublished)
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * @param $headline
     *
     * @return $this
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $image
     *
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * @param $publication
     *
     * @return $this
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * @return array
     */
    public static function getPublicationStatus()
    {
        return ['published', 'draft'];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}
