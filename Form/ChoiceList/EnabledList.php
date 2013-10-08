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

use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * Class EnabledList
 *
 * @package Black\Bundle\PageBundle\Form\ChoiceList
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class EnabledList extends LazyChoiceList
{
    /**
     * @var \Black\Bundle\ConfigBundle\Model\ConfigManagerInterface
     */
    private $manager;

    /**
     * @param \Black\Bundle\ConfigBundle\Model\ConfigManagerInterface $manager
     */
    public function __construct(ConfigManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return SimpleChoiceList
     */
    protected function loadChoiceList()
    {
        $property   = $this->getPageProperty();

        $array = array(
            'public'    => 'black.page.choiceList.enabled.choice.public',
            'private'   => 'black.page.choiceList.enabled.choice.private'
        );

        if ('true' === $property['page_protected']) {
            $array += array(
                'protected' => 'black.page.choiceList.enabled.choice.protected'
            );
        }

        $choices = new SimpleChoiceList($array);

        return $choices;
    }

    /**
     * @return mixed
     */
    protected function getPageProperty()
    {
        $property = $this->manager->findPropertyByName('Page');

        return $property->getValue();
    }
}
