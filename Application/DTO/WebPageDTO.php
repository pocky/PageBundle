<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\DTO;

use Black\DDD\DDDinPHP\Application\DTO\DTOInterface;

/**
 * Class WebPage
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageDTO implements DTOInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var null
     */
    protected $author;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $headline;

    /**
     * @var string
     */
    protected $about;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var
     */
    protected $creator;

    /**
     * @var
     */
    protected $editor;

    /**
     * @var string
     */
    protected $context;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param $id
     * @param $author
     * @param string $name
     * @param null $headline
     * @param null $about
     * @param null $text
     */
    public function __construct($id, $author, $name = 'New WebPage!', $headline = null, $about = null, $text = null)
    {
        $this->id        = $id;
        $this->author    = $author;
        $this->name      = $name;
        $this->headline  = $headline;
        $this->about     = $about;
        $this->text      = $text;
        $this->creator   = $author;
        $this->editor    = $author;
        $this->context   = "http://schema.org";
        $this->type      = "WebPage";
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null
     */
    public function getAuthor()
    {
        return $this->author;
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
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @return mixed
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return json_encode([
                $this->id,
                $this->author,
                $this->name,
                $this->headline,
                $this->about,
                $this->text,
                $this->creator,
                $this->editor,
                $this->context,
                $this->type,
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
       return list(
           $this->id,
           $this->author,
           $this->name,
           $this->headline,
           $this->about,
           $this->text,
        ) = json_decode($serialized);
    }
} 