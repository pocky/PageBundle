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

use Black\Bundle\PageBundle\Domain\Model\WebPageId as AbstractWebPageId;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class WebPageId
 *
 * {@inheritdoc}
 *
 * @ORM\Embeddable()
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageId extends AbstractWebPageId
{
    /**
     * @ODM\String
     */
    protected $value;
}
