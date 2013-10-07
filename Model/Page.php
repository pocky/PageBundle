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

/**
 * Class Page
 *
 * @package Black\Bundle\PageBundle\Model
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class Page implements PageInterface
{
    /**
     * @var
     */
    protected $about;

    /**
     * @var
     */
    protected $author;

    /**
     * @var
     */
    protected $datePublished;

    /**
     * @var
     */
    protected $image;

    /**
     * @Assert\Choice(callback = "getStatusPublication")
     */
    protected $status;

    /**
     * @var
     */
    protected $text;

    /**
     * @var
     */
    protected $primaryImageOfPage;

    /**
     * @var
     * @Assert\Choice(callback = "getStatusEnabled")
     */
    protected $enabled;

    /**
     * @var string
     */
    protected $routeName = 'page_show';

    /**
     *
     */
    public function __construct()
    {
        $this->datePublished    = new \DateTime('now');
        $this->enabled          = 'public';
        $this->status           = 'draft';
    }

    /**
     * @return string
     */
    public function computeEtag()
    {
        return md5($this->getText());
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
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @param string $about
     *
     * @return $this
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
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
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * @param datetime $datePublished
     *
     * @return $this
     */
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public static function getStatusPublication()
    {
        return array('draft', 'publish');
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrimaryImageOfPage()
    {
        return $this->primaryImageOfPage;
    }

    /**
     * @param string $primaryImageOfPage
     */
    public function setPrimaryImageOfPage($primaryImageOfPage)
    {
        $this->primaryImageOfPage = $primaryImageOfPage;
    }

    /**
     * @return array
     */
    public static function getStatusEnabled()
    {
        return array('public', 'private', 'protected');
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param string $enabled
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPublic()
    {
        if ('public' === $this->getEnabled()) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isProtected()
    {
        if ('protected' === $this->getEnabled()) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isPrivate()
    {
        if ('private' === $this->getEnabled()) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * Upload
     */
    public function upload()
    {
        if (null == $this->image) {
            return;
        }

        $this->image->move($this->getUploadRootDir(), $this->image->getClientOriginalName());
        $this->primaryImageOfPage = $this->image->getClientOriginalName();
        $this->image = null;
    }

    /**
     * @return string
     */
    public function getUploadRootDir()
    {
        return __DIR__ . '/../../../../../web/' . $this->getUploadDir();
    }

    /**
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->primaryImageOfPage ? null : $this->getUploadRootDir().'/'.$this->primaryImageOfPage;
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->primaryImageOfPage ? null : $this->getUploadDir().'/'.$this->primaryImageOfPage;
    }

    /**
     * @return string
     */
    public function getUploadDir()
    {
        return 'uploads/page';
    }
}
