<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Blackroom\Bundle\PageBundle\Document;

use Blackroom\Bundle\PageBundle\Model\Page as AbstractPage;
use Blackroom\Bundle\EngineBundle\Traits\ThingDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Page Document
 *
 * @ODM\MappedSuperclass()
 */
class Page extends AbstractPage
{
    use ThingDocument;

    /**
     * @ODM\String
     */
    protected $author;

    /**
     * @ODM\Date
     * @Gedmo\Timestampable(on="create")
     */
    protected $datePublished;

    /**
     * @ODM\String
     * @Assert\Image(maxSize="2M")
     */
    protected $image;

    /**
     * @ODM\String
     */
    protected $status;

    /**
     * @ODM\String
     * @Assert\Type(type="string")
     */
    protected $text;

    /**
     * @ODM\String
     */
    protected $primaryImageOfPage;

    /**
     * @ODM\PostRemove()
     */
    public function removeUpload()
    {
        if ($image = $this->getAbsolutePath()) {
            unlink($image);
        }
    }
}
