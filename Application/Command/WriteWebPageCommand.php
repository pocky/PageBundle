<?php

namespace Black\Bundle\PageBundle\Application\Command;

use Black\Component\Page\Domain\Model\WebPageId;
use Black\Component\Page\Infrastructure\CQRS\Handler\WriteWebPageHandler;
use Black\Component\Page\Infrastructure\Service\WebPageReadService;
use Black\DDD\CQRSinPHP\Infrastructure\CQRS\Bus;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class WriteWebPageCommand
 */
class WriteWebPageCommand extends ContainerAwareCommand
{
    /**
     * @var Bus
     */
    protected $bus;

    /**
     * @var WriteWebPageHandler
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
     * @param WriteWebPageHandler $handler
     * @param WebPageReadService $service
     * @param $commandName
     */
    public function __construct(
        Bus $bus,
        WriteWebPageHandler $handler,
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
            ->setName('black:page:write')
            ->setDescription('Write a new page')
            ->addArgument('id', InputArgument::OPTIONAL, 'The page identifier')
            ->addArgument('headline', InputArgument::OPTIONAL, 'The headline')
            ->addArgument('about', InputArgument::OPTIONAL, 'The about ')
            ->addArgument('text', InputArgument::OPTIONAL, 'The text')
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
                'Please give an id name:',
                function ($id) {
                    if (empty($id)) {
                        throw new \InvalidArgumentException('Id cannot be empty!');
                    }

                    return $id;
                }
            );

            $input->setArgument('id', $id);
        }
        
        if (!$input->getArgument('headline')) {
            $headline = $dialog->askAndValidate(
                $output,
                'Please give an headline name:',
                function ($headline) {
                    if (empty($headline)) {
                        throw new \InvalidArgumentException('Headline cannot be empty!');
                    }

                    return $headline;
                }
            );

            $input->setArgument('headline', $headline);
        }

        if (!$input->getArgument('about')) {
            $about = $dialog->askAndValidate(
                $output,
                'Please give an about name:',
                function ($about) {
                    if (empty($about)) {
                        throw new \InvalidArgumentException('About cannot be empty!');
                    }

                    return $about;
                }
            );

            $input->setArgument('about', $about);
        }

        if (!$input->getArgument('text')) {
            $text = $dialog->askAndValidate(
                $output,
                'Please give an text name:',
                function ($text) {
                    if (empty($text)) {
                        throw new \InvalidArgumentException('Text cannot be empty!');
                    }

                    return $text;
                }
            );

            $input->setArgument('text', $text);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pageId = new WebPageId($input->getArgument('id'));
        $page = $this->service->read($pageId);

        if ($page) {
            $this->bus->register($this->commandName, $this->handler);
            $this->bus->handle(new $this->commandName(
                $pageId,
                $input->getArgument('headline'),
                $input->getArgument('about'),
                $input->getArgument('text')
            ));
        }
    }
}
