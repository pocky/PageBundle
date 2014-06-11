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

use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * Class PublicationStatusList
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PublicationStatusList extends LazyChoiceList
{
    /**
     * @return SimpleChoiceList
     */
    protected function loadChoiceList()
    {
        $array = [
            'draft' => 'black.bundle.page.choiceList.status.choice.draft',
            'publish' => 'black.bundle.page.choiceList.status.choice.publish'
        ];

        $choices = new SimpleChoiceList($array);

        return $choices;
    }
}
