<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Factory;

use Black\Bundle\PageBundle\Model\WebPageManagerInterface;

/**
 * Class CreateWebPage
 *
 * Create a new WebPage
 *
 * @package Black\Bundle\ConfigBundle\Factory
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreateWebPage
{
    /**
     * @var \Black\Bundle\ConfigBundle\Model\ConfigManagerInterface
     */
    protected $manager;

    /**
     * Construct the factory
     *
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
        $property = $this->manager->createInstance();
        $property
            ->setName($name)
            ->setPublication($publication);

        $this->manager->persist($property);
        $this->manager->flush();

        return $property;
    }
} 
