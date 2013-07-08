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

use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class StatusList extends LazyChoiceList
{
    protected function loadChoiceList()
    {
        $array = array(
            'draft'     => 'page.admin.page.status.choice.draft',
            'publish'   => 'page.admin.page.status.choice.publish'
        );

        $choices = new SimpleChoiceList($array);

        return $choices;
    }

    protected function getClass()
    {
        return $this;
    }
}
