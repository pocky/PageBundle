<?php

namespace Black\Bundle\PageBundle\Application\Command;

use Black\Component\Page\Domain\Model\WebPageId;
use Black\Component\Page\Infrastructure\CQRS\Handler\DepublishWebPageHandler;
use Black\Component\Page\Infrastructure\Service\WebPageReadService;
use Black\DDD\CQRSinPHP\Infrastructure\CQRS\Bus;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DepublishWebPageCommand
 */
class DepublishWebPageCommand extends ContainerAwareCommand
{
    /**
     * @var Bus
     */
    protected $bus;

    /**
     * @var DepublishWebPageHandler
     */
    protected $handler;

    /**
     * @var WebPageReadService
     */
    protected $service;

    /**
     * @var
     */
    protected $commandName;

    /**
     * @param Bus $bus
     * @param DepublishWebPageHandler $handler
     * @param WebPageReadService $service
     * @param $commandName
     */
    public function __construct(
        Bus $bus,
        DepublishWebPageHandler $handler,
        WebPageReadService $service,
        $commandName
    ) {
        $this->bus = $bus;
        $this->handler = $handler;
        $this->service = $service;
        $this->commandName = $commandName;

        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('black:page:depublish')
            ->setDescription('Publish a new page')
            ->addArgument('id', InputArgument::OPTIONAL, 'The page identifier')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');

        if (!$input->getArgument('id')) {
            $id = $dialog->askAndValidate(
                $output,
                'Please give an id:',
                function ($id) {
                    if (empty($id)) {
                        throw new \InvalidArgumentException('Id cannot be empty!');
                    }

                    return $id;
                }
            );

            $input->setArgument('id', $id);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pageId = new WebPageId($input->getArgument('id'));
        $page = $this->service->read($pageId);

        if ($page) {
            $this->bus->register($this->commandName, $this->handler);
            $this->bus->handle(new $this->commandName(
                $page
            ));
        }
    }
}
