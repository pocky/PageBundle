<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Entity;

use Black\Bundle\PageBundle\Model\Page as AbstractPage;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Page
 *
 * @ORM\MappedSuperclass()
 *
 * @package Black\Bundle\PageBundle\Entity
 * @author  Alexandre Balmes <abalmes@activcompany.com>
 * @license http://creativecommons.org/licenses/by-nc-nd/3.0/legalcode CC BY-NC-ND 3.0
 */
abstract class Page extends AbstractPage
{
    use TimestampableEntity;

    /**
     * A short description of the item
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * The name of the item
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * The slug of the item
     *
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    /**
     * URL of the item
     *
     * @ORM\Column(name="url", type="text", nullable=true)
     */
    protected $url;

    /**
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    protected $author;

    /**
     * @ORM\Column(name="date_published", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    protected $datePublished;

    /**
     * @ORM\Column(name="image", type="string", nullable=true)
     * @Assert\Image(maxSize="2M")
     */
    protected $image;

    /**
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    protected $status;

    /**
     * @ORM\Column(name="text", type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $text;

    /**
     * @ORM\Column(name="primary_image_of_page", type="string", nullable=true)
     */
    protected $primaryImageOfPage;

    /**
     * @ORM\Column(name="enabled", type="string", length=255, nullable=true)
     */
    protected $enabled;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($image = $this->getAbsolutePath()) {
            unlink($image);
        }
    }
}
