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

use Black\Bundle\PageBundle\Model\WebPageInterface;
use Black\Bundle\PageBundle\Model\WebPageManagerInterface;
use Black\Bundle\PageBundle\Factory\CreateWebPage;
use Black\Bundle\CommonBundle\Command\CommandInterface;

/**
 * Class CreateWebPageCommand
 *
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreateWebPageCommand implements CommandInterface
{
    /**
     * @var
     */
    protected $webPage;

    /**
     * @var
     */
    protected $manager;

    /**
     * @var
     */
    protected $factory;

    /**
     * @param WebPageInterface        $webPage
     * @param WebPageManagerInterface $manager
     * @param CreateWebPage           $factory
     */
    public function construct(WebPageInterface $webPage, WebPageManagerInterface $manager, CreateWebPage $factory)
    {
        $this->webPage = $webPage;
        $this->manager = $manager;
        $this->factory = $factory;
    }

    /**
     * @return mixed
     */
    public function getWebPage()
    {
        return $this->webPage;
    }

    /**
     * @return mixed
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @return mixed
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
