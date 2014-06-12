<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\CQRS\CreateWebPage;

use Black\Bundle\PageBundle\Domain\Model\WebPageInterface;
use Black\DDD\DDDinPHP\Infrastructure\CQRS\CommandInterface;
use Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface;

/**
 * Class CreateWebPageCommand
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
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
     * @param WebPageInterface        $webPage
     * @param WebPageManagerInterface $manager
     */
    public function construct(WebPageInterface $webPage, WebPageManagerInterface $manager)
    {
        $this->webPage = $webPage;
        $this->manager = $manager;
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
}
