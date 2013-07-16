<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Entity;

use Black\Bundle\PageBundle\Model\Page as AbstractPage;
use Black\Bundle\EngineBundle\Traits\ThingEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Page Entity
 *
 * @ORM\Table(name="page",indexes={
 *          @ORM\Index(name="name_idx", columns={"name"})
 *      })
 * @ORM\Entity(repositoryClass="Black\Bundle\PageBundle\Entity\PageRepository")
 */
class Page extends AbstractPage
{
    use ThingEntityTrait;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @ORM\Column(name="text", type="string", nullable=true)
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
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($image = $this->getAbsolutePath()) {
            unlink($image);
        }
    }
}
