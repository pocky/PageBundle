<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Form\ChoiceList;

use Black\Bundle\PageBundle\Model\WebPageManagerInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * WebPageIdList create an array of list with the id/name as key/value
 *
 * @package Black\Bundle\PageBundle\Form\ChoiceList
 * @author  Alexandre Balmes <albalmes@gmail.com>
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
        $choices = array();
        $pages   = $this->getWebPages();

        foreach ($pages as $page) {
            $choices += array($page->getId() => $page->getName());
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
