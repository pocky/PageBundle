<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Command\CreateWebPage;

use Black\Bundle\CommonBundle\Command\HandlerInterface;

/**
 * Class CreateWebPageHandler
 *
 * @package Black\Bundle\PageBundle\Command\CreateWebPage
 * @author  Alexandre Balmes <albalmes@gmail.com>
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
