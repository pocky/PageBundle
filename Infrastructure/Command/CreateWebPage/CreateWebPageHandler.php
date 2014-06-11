<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\Command\CreateWebPage;

use Black\Bundle\CommonBundle\Command\HandlerInterface;

/**
 * Class CreateWebPageHandler
 *
 * @package Black\Bundle\PageBundle\Application\Command\CreateWebPage
 * @author  Alexandre Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreateWebPageHandler implements HandlerInterface
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
     * @param CreateWebPageCommand $command
     */
    public function invoke(CreateWebPageCommand $command)
    {
        $this->command = $command;
    }
}
