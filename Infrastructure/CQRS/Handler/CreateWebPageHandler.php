<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\CQRS\Handler;

use Black\Bundle\PageBundle\Infrastructure\CQRS\Command\CreateWebPageCommand;
use Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface;
use Black\Bundle\PageBundle\Infrastructure\Service\WebPageWriteService;
use Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandHandlerInterface;

/**
 * Class CreateWebPageHandler
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
final class CreateWebPageHandler implements CommandHandlerInterface
{
    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\Service\WebPageWriteService
     */
    protected $service;

    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface
     */
    protected $manager;

    /**
     * @param WebPageWriteService $service
     * @param WebPageManagerInterface $manager
     */
    public function __construct(WebPageWriteService $service, WebPageManagerInterface $manager)
    {
        $this->service = $service;
        $this->manager = $manager;
    }

    /**
     * @param $command
     */
    public function handle(CreateWebPageCommand $command)
    {
        $this->service->create($this->manager, $command->getName());
    }
} 