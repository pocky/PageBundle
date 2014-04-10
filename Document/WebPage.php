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

use Black\Bundle\PageBundle\Model\WebPage as AbstractWebPage;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * {@inheritdoc}
 *
 * @ODM\MappedSuperclass(repositoryClass="")
 *
 * @package Black\Bundle\PageBundle\Document
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class WebPage extends AbstractWebPage
{
    /**
     * {@inheritdoc}
     *
     * @ODM\String
     */
    protected $name;

    /**
     * {@inheritdoc}
     *
     * @ODM\String
     */
    protected $slug;

    /**
     * {@inheritdoc}
     *
     * @ODM\String
     */
    protected $headline;

    /**
     * {@inheritdoc}
     *
     * @ODM\String
     */
    protected $text;

    /**
     * {@inheritdoc}
     *
     * @ODM\String
     */
    protected $author;

    /**
     * {@inheritdoc}
     *
     * @ODM\String
     */
    protected $image;

    /**
     * {@inheritdoc}
     *
     * @ODM\String
     */
    protected $publication;

    /**
     * {@inheritdoc}
     *
     * @ODM\Date
     */
    protected $dateCreated;

    /**
     * {@inheritdoc}
     *
     * @ODM\Date
     */
    protected $dateModified;

    /**
     * {@inheritdoc}
     *
     * @ODM\Date
     */
    protected $datePublished;
}