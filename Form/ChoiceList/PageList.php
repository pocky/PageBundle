<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Form\ChoiceList;

use Black\Bundle\PageBundle\Model\PageManagerInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * PageList
 */
class PageList extends LazyChoiceList
{
    /**
     * @var PageManagerInterface
     */
    private $manager;

    /**
     * @param PageManagerInterface $manager
     */
    public function __construct(PageManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface|SimpleChoiceList
     */
    protected function loadChoiceList()
    {
        $choices    = array();
        $pages      = $this->getPages();

        foreach ($pages as $page) {
            $choices += array('/page/' . $page->getSlug() . '.html' => $page->getName());
        }

        $choices += array('other' => 'page.admin.page.item.choice.other');

        $choices = new SimpleChoiceList($choices);

        return $choices;
    }

    /**
     * @return mixed
     */
    protected function getPages()
    {
        $pages = $this->manager->findPublishedPages();

        return $pages;
    }
}
