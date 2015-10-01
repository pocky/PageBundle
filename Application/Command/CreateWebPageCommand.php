<?php

namespace Black\Bundle\PageBundle\Application\Command;

use Black\Component\Page\Domain\Model\WebPageId;
use Black\Component\Page\Infrastructure\CQRS\Handler\CreateWebPageHandler;
use Black\DDD\CQRSinPHP\Infrastructure\CQRS\Bus;
use Rhumsaa\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateWebPageCommand
 */
class CreateWebPageCommand extends ContainerAwareCommand
{
    /**
     * @var Bus
     */
    protected $bus;

    /**
     * @var CreateWebPageHandler
     */
    protected $handler;

    /**
     * @var
     */
    protected $commandName;

    /**
     * @var \Symfony\Component\Console\Helper\HelperInterface
     */
    protected $dialog;

    /**
     * @param Bus $bus
     * @param CreateWebPageHandler $handler
     * @param $commandName
     */
    public function __construct(
        Bus $bus,
        CreateWebPageHandler $handler,
        $commandName
    ) {
        $this->bus = $bus;
        $this->handler = $handler;
        $this->commandName = $commandName;

        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('black:page:create')
            ->setDescription('Create a new page')
            ->addArgument('author', InputArgument::OPTIONAL, 'The author')
            ->addArgument('name', InputArgument::OPTIONAL, 'The page name');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');

        if (!$input->getArgument('author')) {
            $author = $dialog->askAndValidate(
                $output,
                'Please give an author name:',
                function ($author) {
                    if (empty($author)) {
                        throw new \InvalidArgumentException('Author cannot be empty!');
                    }

                    return $author;
                }
            );

            $input->setArgument('author', $author);
        }

        if (!$input->getArgument('name')) {
            $name = $dialog->askAndValidate(
                $output,
                'Please choose a name:',
                function ($name) {
                    if (empty($name)) {
                        throw new \InvalidArgumentException('Name cannot be empty!');
                    }

                    return $name;
                }
            );

            $input->setArgument('name', $name);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pageId = new WebPageId(Uuid::uuid4());

        $this->bus->register($this->commandName, $this->handler);
        $this->bus->handle(new $this->commandName(
            $pageId,
            $input->getArgument('author'),
            $input->getArgument('name')
        ));
    }
}
