<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\Command\UpdateWebPage;

use Black\Bundle\CommonBundle\Command\HandlerInterface;

/**
 * Class UpdateWebPageHandler
 *
 * @package Black\Bundle\PageBundle\Application\Command\UpdateWebPage
 * @author  Alexandre Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class UpdateWebPageHandler implements HandlerInterface
{
    /**
     * @var
     */
    protected $command;

    /**
     *
     */
    public function execute()
    {
        $page = $this->command->getWebPage();

        if ($page) {
            $this->command->getManager()->persist($page);

            return $page;
        }
    }

    /**
     * @param UpdateWebPageCommand $command
     */
    public function invoke(UpdateWebPageCommand $command)
    {
        $this->command = $command;
    }
}
