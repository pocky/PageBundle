<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Form\Type;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PageConfigType
 *
 * @package Black\Bundle\PageBundle\Form\Type
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageConfigType extends AbstractType
{
    /**
     * @var type
     */
    protected $class;

    /**
     * @var
     */
    protected $buttonSubscriber;

    /**
     * @param string $class The Person class name
     */
    public function __construct($class, EventSubscriberInterface $buttonSubscriber)
    {
        $this->class            = $class;
        $this->buttonSubscriber = $buttonSubscriber;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->buttonSubscriber);
        $builder
            ->remove('name')
            ->add(
                $builder
                ->create('value', 'form', array(
                        'by_reference'  => false,
                        'label'         => 'black.bundle.page.type.config.label'
                    )
                )
                ->add('page_protected', 'choice', array(
                        'label'             => 'black.bundle.page.type.config.protected.label',
                        'required'          => false,
                        'empty_value'       => 'black.bundle.page.type.config.protected.empty',
                        'preferred_choices' => array('false'),
                        'choices'           => array(
                            'true'          => 'black.bundle.page.type.config.protected.choice.yes',
                            'false'         => 'black.bundle.page.type.config.protected.choice.no'
                        )
                    )
                )
                ->add('page_home', 'black_page_choice_list_page_id', array(
                        'label'         => 'black.bundle.page.type.config.home.label',
                        'required'      => false,
                        'empty_value'   => 'black.bundle.page.type.config.home.empty'
                    )
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'            => $this->class,
                'intention'             => 'page_config_form',
                'translation_domain'    => 'form'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_page_config';
    }
}
