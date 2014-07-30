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
     * @var string
     */
    protected $context;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param $id
     * @param $name
     * @param $headline
     * @param $about
     * @param $text
     */
    public function __construct($id, $name = 'New WebPage!', $headline = null, $about = null, $text = null)
    {
        $this->id       = $id;
        $this->name     = $name;
        $this->headline = $headline;
        $this->about    = $about;
        $this->text     = $text;
        $this->context  = "http://schema.org";
        $this->type     = "WebPage";
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
        return serialize([
                $this->id,
                $this->name,
                $this->headline,
                $this->about,
                $this->text,
                $this->context,
                $this->type
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
       return list(
            $this->id,
            $this->name,
            $this->headline,
            $this->about,
            $this->text,
            $this->context,
            $this->type
        ) = unserialize($serialized);
    }
} 