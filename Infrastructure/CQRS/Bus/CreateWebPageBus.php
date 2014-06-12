<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\CQRS\Bus;

use Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandBusInterface;
use Black\Bundle\PageBundle\Infrastructure\CQRS\CreateWebPage\CreateWebPageCommand;
use Black\Bundle\PageBundle\Infrastructure\CQRS\CreateWebPage\CreateWebPageHandler;
use Black\Bundle\PageBundle\Domain\Model\WebPageInterface;
use Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface;

/**
 * Class CreateWebPageBus
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreateWebPageBus implements CommandBusInterface
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
