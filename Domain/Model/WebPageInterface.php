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

use Black\DDD\DDDinPHP\Domain\Model\EntityInterface;

/**
 * Interface WebPageInterface
 *
 * @package Black\Bundle\PageBundle\Domain\Model
 */
interface WebPageInterface extends EntityInterface
{
    public function getAuthor();

    public function getName();

    public function getSlug();

    public function getHeadline();

    public function getAbout();

    public function getText();

    public function getDateCreated();

    public function getDateModified();

    public function getDatePublished();

    public function write($headline, $about, $text);

    public function publish(\DateTime $dateTime);

    public function depublish();

    public function edit($name, $headline, $about, $text);
}
