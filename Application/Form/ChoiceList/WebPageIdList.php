<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\Form\ChoiceList;

use Black\Bundle\PageBundle\Infrastructure\Doctrine\WebPageManagerInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * Class WebPageIdList
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageIdList extends LazyChoiceList
{
    /**
     * @var WebPageManagerInterface
     */
    private $manager;

    /**
     * @param WebPageManagerInterface $manager
     */
    public function __construct(WebPageManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface|SimpleChoiceList
     */
    protected function loadChoiceList()
    {
        $choices = [];
        $pages   = $this->getWebPages();

        foreach ($pages as $page) {
            $choices += [$page->getId() => $page->getName()];
        }

        $choices = new SimpleChoiceList($choices);

        return $choices;
    }

    /**
     * @return mixed
     */
    protected function getWebPages()
    {
        $pages = $this->manager->findPublishedWebPages();

        return $pages;
    }
}
