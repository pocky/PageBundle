<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\Command\Bus;

use Black\Bundle\CommonBundle\Command\BusInterface;
use Black\Bundle\PageBundle\Application\Command\UpdateWebPage\UpdateWebPageCommand;
use Black\Bundle\PageBundle\Application\Command\UpdateWebPage\UpdateWebPageHandler;
use Black\Bundle\PageBundle\Application\Model\WebPageInterface;
use Black\Bundle\PageBundle\Application\Model\WebPageManagerInterface;

/**
 * Class UpdateWebPageBus
 *
 * @package Black\Bundle\PageBundle\Application\Command\Bus
 * @author  Alexandre Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class UpdateWebPageBus implements BusInterface
{
    /**
     * @param UpdateWebPageHandler    $handler
     * @param WebPageManagerInterface $manager
     */
    public function __construct(
        UpdateWebPageHandler $handler,
        WebPageManagerInterface $manager
    ) {
        $this->handler = $handler;
        $this->manager = $manager;
    }

    /**
     * @param WebPageInterface $webPage
     *
     * @return mixed
     */
    public function handle(WebPageInterface $webPage)
    {
        $page = $this->create($webPage);

        if ($page) {
            $this->manager->flush();

            return $page;
        }
    }

    /**
     * @param WebPageInterface $webPage
     *
     * @return mixed
     */
    protected function create(WebPageInterface $webPage)
    {
        $command = new UpdateWebPageCommand($webPage, $this->manager);
        $this->handler->invoke($command);

        $result = $this->handler->execute();

        return $result;
    }
}
