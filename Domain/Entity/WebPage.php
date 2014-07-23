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
 * Class WebPage
 *
 * {@inheritdoc}
 *
 * @ORM\MappedSuperclass(repositoryClass="Black\Bundle\PageBundle\Infrastructure\Persistence\WebPageEntityRepository")
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPage extends AbstractWebPage
{
    /**
     * {@inheritdoc}
     *
     * @ODM\Embedded(class="Black\Bundle\PageBundle\Domain\Entity\WebPageId")
     */
    protected $webPageId;

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
    protected $about;

    /**
     * {@inheritdoc}
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $text;

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
}
