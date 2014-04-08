<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Document;

use Black\Bundle\PageBundle\Model\Page as AbstractPage;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Timestampable\Traits\TimestampableDocument;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Page
 *
 * @ODM\MappedSuperclass()
 *
 * @package Black\Bundle\PageBundle\Document
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class Page extends AbstractPage
{
    use TimestampableDocument;

    /**
     * @ODM\String
     */
    protected $description;

    /**
     * The name of the item
     *
     * @ODM\String
     */
    protected $name;

    /**
     * The slug of the item
     *
     * @ODM\String
     */
    protected $slug;

    /**
     * URL of the items
     *
     * @ODM\String
     */
    protected $url;

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
