<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle;

use Black\Bundle\PageBundle\DependencyInjection\BlackPageExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class BlackPageBundle
 *
 * @package Black\Bundle\PageBundle
 * @author  Alexandre Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class BlackPageBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new BlackPageExtension();
    }
}
