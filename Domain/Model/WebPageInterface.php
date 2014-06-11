<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Domain\Model;

/**
 * Interface WebPageInterface
 *
 * @package Black\Bundle\PageBundle\Domain\Model
 */
interface WebPageInterface
{
    /**
     * @return mixed
     */
    public function getAuthor();

    /**
     * @return mixed
     */
    public function getDateCreated();

    /**
     * @return mixed
     */
    public function getDateModified();

    /**
     * @return mixed
     */
    public function getDatePublished();

    /**
     * @return mixed
     */
    public function getHeadline();

    /**
     * @return mixed
     */
    public function getImage();

    /**
     * @return mixed
     */
    public function getPublication();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getSlug();

    /**
     * @return mixed
     */
    public function getText();
}
