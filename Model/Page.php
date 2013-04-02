<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Blackroom\Bundle\PageBundle\Model;

use Blackroom\Bundle\EngineBundle\Model\Person\PersonInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Page implements PageInterface
{
    protected $about;
    protected $author;
    protected $datePublished;
    protected $image;
    /**
     * @Assert\Choice(callback = "getStatusPublication")
     */
    protected $status;
    protected $text;
    protected $primaryImageOfPage;

    public static function getStatusPublication()
    {
        return array('draft', 'publish');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAbout()
    {
        return $this->about;
    }

    public function setAbout($about)
    {
        $this->about = $about;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(PersonInterface $author)
    {
        $this->author = $author;
    }

    public function getDatePublished()
    {
        return $this->datePublished;
    }

    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getPrimaryImageOfPage()
    {
        return $this->primaryImageOfPage;
    }

    public function setPrimaryImageOfPage($primaryImageOfPage)
    {
        $this->primaryImageOfPage = $primaryImageOfPage;
    }

    public function upload()
    {
        if (null == $this->image) {
            return;
        }

        $this->image->move($this->getUploadRootDir(), $this->image->getClientOriginalName());
        $this->primaryImageOfPage = $this->image->getClientOriginalName();
        $this->image = null;
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/page';
    }

    public function getAbsolutePath()
    {
        return null === $this->primaryImageOfPage ? null : $this->getUploadRootDir().'/'.$this->primaryImageOfPage;
    }

    public function getWebPath()
    {
        return null === $this->primaryImageOfPage ? null : $this->getUploadDir().'/'.$this->primaryImageOfPage;
    }
}

