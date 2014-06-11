<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Domain\Entity;

use Black\Bundle\PageBundle\Domain\Model\WebPage as AbstractWebPage;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * {@inheritdoc}
 *
 * @ORM\MappedSuperclass(repositoryClass="Black\Bundle\PageBundle\Domain\Entity\WebPageRepository")
 *
 * @package Black\Bundle\PageBundle\Domain\Entity
 * @author  Alexandre Balmes <abalmes@activcompany.com>
 * @license http://creativecommons.org/licenses/by-nc-nd/3.0/legalcode CC BY-NC-ND 3.0
 */
abstract class WebPage extends AbstractWebPage
{
    /**
     * {@inheritdoc}
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * {@inheritdoc}
     *
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    /**
     * {@inheritdoc}
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $headline;

    /**
     * {@inheritdoc}
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $text;

    /**
     * {@inheritdoc}
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $author;

    /**
     * {@inheritdoc}
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;

    /**
     * {@inheritdoc}
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $publication;

    /**
     * {@inheritdoc}
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;

    /**
     * {@inheritdoc}
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateModified;

    /**
     * {@inheritdoc}
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $datePublished;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->dateCreated   = new \DateTime();
        $this->dateModified  = new \DateTime();
        $this->datePublished = new \DateTime();
    }
}
