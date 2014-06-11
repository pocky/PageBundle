<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\CQRS\UpdateWebPage;

use Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandHandlerInterface;

/**
 * Class UpdateWebPageHandler
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class UpdateWebPageHandler implements CommandHandlerInterface
{
    /**
     *
     */
    public function handle($command)
    {
        $page = $command->getWebPage();

        if ($page) {
            $command->getManager()->persist($page);

            return $page;
        }
    }
}
