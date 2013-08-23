<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Command;

use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class InstallConfigCommand
 *
 * @package Black\Bundle\PageBundle\Command
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class InstallConfigCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('black:page:install')
            ->setDescription('Create needed object for your orm/odm');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager    = $this->getManager();
        $output->writeln('<comment>First step: Create general parameter</comment>');

        $result   = $this->createPage($manager, $output);
        $output->writeln($result);


        $manager->flush();

    }

    /**
     * @param ConfigManagerInterface $manager
     * @param OutputInterface        $output
     *
     * @return string
     */
    private function createPage(ConfigManagerInterface $manager, OutputInterface $output)
    {
        if ($manager->findPropertyByName('Page')) {
            return '<error>The property page already exist!</error>';
        }

        $object = $manager->createInstance();
        $value  = array('page_home' => null);

        $dialog = $this->getHelperSet()->get('dialog');

        $protected = $dialog->askConfirmation(
            $output,
            '<question>Do you want to active page protection? (y/n, default: n)</question>',
            false
        );

        if ($protected == true) {
            $protected = "true";
        } else {
            $protected = "false";
        }

        $value += array('page_protected' => $protected);


        $object
            ->setName('Page')
            ->setValue($value)
            ->setProtected(true);

        $manager->persist($object);

        return '<info>The property Page was created!</info>';
    }

    /**
     * @return object
     */
    private function getManager()
    {
        return $this->getContainer()->get('black_config.manager.config');
    }
}
