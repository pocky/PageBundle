<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PageBundle\Model;

/**
 * Class PageInterface
 *
 * @package Black\Bundle\PageBundle\Model
 */
interface PageInterface
{
    /**
     * @return mixed
     */
    static public function getStatusPublication();

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getAbout();

    /**
     * @return mixed
     */
    public function getAuthor();

    /**
     * @return mixed
     */
    public function getDatePublished();

    /**
     * @return mixed
     */
    public function getImage();

    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @return mixed
     */
    public function getText();

    /**
     * @return mixed
     */
    public function getPrimaryImageOfPage();

    /**
     * @return mixed
     */
    public function getEnabled();

    /**
     * @return mixed
     */
    public function isPublic();

    /**
     * @return mixed
     */
    public function isProtected();

    /**
     * @return mixed
     */
    public function isPrivate();

    /**
     * @return mixed
     */
    public function getRouteName();
}
