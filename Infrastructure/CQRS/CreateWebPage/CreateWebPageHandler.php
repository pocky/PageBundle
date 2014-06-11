<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\CQRS\CreateWebPage;

use Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandHandlerInterface;

/**
 * Class CreateWebPageHandler
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreateWebPageHandler implements CommandHandlerInterface
{
    /**
     *
     */
    public function handle($command)
    {
        $page = $command->getWebPage();

        if ($page) {
            $this->command->getManager()->persist($page);

            return $page;
        }
    }
}
