<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PageBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

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
     * @return array
     */
    public static function getStatusPublication()
    {
        return array('draft', 'publish');
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
     * @param $about
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
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * @param $datePublished
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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status
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
     * @param $text
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
     * @param $primaryImageOfPage
     */
    public function setPrimaryImageOfPage($primaryImageOfPage)
    {
        $this->primaryImageOfPage = $primaryImageOfPage;
    }

    /**
     *
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
    protected function getUploadRootDir()
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
    protected function getUploadDir()
    {
        return 'uploads/page';
    }
}

