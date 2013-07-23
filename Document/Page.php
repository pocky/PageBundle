<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Document;

use Black\Bundle\PageBundle\Model\Page as AbstractPage;
use Black\Bundle\CommonBundle\Traits\ThingDocumentTrait;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Page Document
 *
 * @ODM\MappedSuperclass()
 */
abstract class Page extends AbstractPage
{
    use ThingDocumentTrait;

    /**
     * @ODM\Id
     */
    protected $id;

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
     * @ODM\String
     */
    protected $enabled;

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
