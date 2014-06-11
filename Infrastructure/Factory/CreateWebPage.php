<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Infrastructure\Factory;

use Black\Bundle\PageBundle\Infrastructure\Model\WebPageManagerInterface;

/**
 * Class CreateWebPage
 *
 * Create a new WebPage
 *
 * @package Black\Bundle\ConfigBundle\Factory
 * @author  Alexandre Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreateWebPage
{
    /**
     * @var \Black\Bundle\PageBundle\Infrastructure\Model\WebPageManagerInterface
     */
    protected $manager;

    /**
     * @param WebPageManagerInterface $manager
     */
    public function __construct(WebPageManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Execute the factory and create a new WebPage property
     *
     * @param string $name
     * @param string $publication
     *
     * @return mixed
     */
    public function execute($name, $publication = 'draft')
    {
        $webPage = $this->manager->createInstance();

        $webPage
            ->setName($name)
            ->setPublication($publication);

        return $webPage;
    }
} 
