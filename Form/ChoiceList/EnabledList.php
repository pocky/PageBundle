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

use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * EnabledList
 */
class EnabledList extends LazyChoiceList
{
    private $manager;

    /**
     * @param \Black\Bundle\ConfigBundle\Model\ConfigManagerInterface $manager
     */
    public function __construct(ConfigManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    protected function loadChoiceList()
    {
        $property   = $this->getPageProperty();

        $array = array(
            'public'    => 'page.admin.page.enabled.choice.public',
            'private'   => 'page.admin.page.enabled.choice.private'
        );

        if ('true' === $property['page_protected']) {
            $array += array(
                'protected' => 'page.admin.page.enabled.choice.protected'
            );
        }

        $choices = new SimpleChoiceList($array);

        return $choices;
    }

    protected function getPageProperty()
    {
        $property = $this->manager->findPropertyByName('Page');

        return $property->getValue();
    }
}
