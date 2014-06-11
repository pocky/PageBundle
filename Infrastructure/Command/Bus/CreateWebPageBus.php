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
use Black\Bundle\PageBundle\Application\Command\CreateWebPage\CreateWebPageCommand;
use Black\Bundle\PageBundle\Application\Command\CreateWebPage\CreateWebPageHandler;
use Black\Bundle\PageBundle\Domain\Model\WebPageInterface;
use Black\Bundle\PageBundle\Domain\Model\WebPageManagerInterface;

/**
 * Class CreateWebPageBus
 *
 * @package Black\Bundle\PageBundle\Application\Command\Bus
 * @author  Alexandre Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreateWebPageBus implements BusInterface
{
    /**
     * @param CreateWebPageHandler    $handler
     * @param WebPageManagerInterface $manager
     */
    public function __construct(
        CreateWebPageHandler $handler,
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
        $command = new CreateWebPageCommand($webPage, $this->manager);
        $this->handler->invoke($command);

        $result = $this->handler->execute();

        return $result;
    }
}
