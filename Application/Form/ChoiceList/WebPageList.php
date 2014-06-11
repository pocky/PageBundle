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

use Black\Bundle\PageBundle\Domain\Model\WebPageManagerInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * Class WebPageList
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageList extends LazyChoiceList
{
    /**
     * @var PageManagerInterface
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
        $choices = array();
        $pages   = $this->getPages();

        $choices += ['other' => 'black.bundle.page.choiceList.page.choice.other'];

        foreach ($pages as $page) {
            $choices += ['/page/' . $page->getSlug() . '.html' => $page->getName()];
        }
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
