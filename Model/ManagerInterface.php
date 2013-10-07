<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Model;

/**
 * Class ManagerInterface
 *
 * @package Black\Bundle\PageBundle\Model
 * @author dallas62 <dallas62@free.fr>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
interface ManagerInterface
{
    /**
     * @return mixed
     */
    public function getManager();

    /**
     * @return mixed
     */
    public function getRepository();

    /**
     * @return mixed
     */
    public function createInstance();
}
