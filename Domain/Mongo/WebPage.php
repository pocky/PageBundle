<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Domain\Mongo;

use Black\Bundle\PageBundle\Domain\Model\WebPage as AbstractWebPage;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class WebPage
 *
 * {@inheritdoc}
 *
 * @ODM\MappedSuperclass(repositoryClass="Black\Bundle\PageBundle\Infrastructure\Persistence\WebPageMongoRepository")
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class WebPage extends AbstractWebPage
{
    /**
     * {@inheritdoc}
     *
     * @ODM\EmbedOne(targetDocument="Black\Bundle\PageBundle\Domain\Mongo\WebPageId")
     */
    protected $webPageId;

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
    protected $about;

    /**
     * {@inheritdoc}
     *
     * @ODM\String
     */
    protected $text;

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
