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

use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * Class PublicationStatusList
 *
 * @package Black\Bundle\PageBundle\Form\ChoiceList
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PublicationStatusList extends LazyChoiceList
{
    /**
     * @return SimpleChoiceList
     */
    protected function loadChoiceList()
    {
        $array = array(
            'draft'     => 'black.bundle.page.choiceList.status.choice.draft',
            'publish'   => 'black.bundle.page.choiceList.status.choice.publish'
        );

        $choices = new SimpleChoiceList($array);

        return $choices;
    }

    /**
     * @return $this
     */
    protected function getClass()
    {
        return $this;
    }
}