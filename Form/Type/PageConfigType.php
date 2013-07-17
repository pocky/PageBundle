<?php

/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Config Type
 *
 * @class ConfigType
 */
class PageConfigType extends AbstractType
{
    private $class;

    /**
     * @param string $class The Person class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('name')
            ->add(
                $builder
                ->create(
                    'value',
                    'form',
                    array(
                        'by_reference'  => false,
                        'label'         => 'page.admin.config.text'
                    )
                )
                ->add(
                    'page_protected',
                    'choice',
                    array(
                        'label'             => 'page.admin.config.protected.text',
                        'required'          => false,
                        'empty_value'       => 'page.admin.config.protected.empty',
                        'preferred_choices' => array('false'),
                        'choices'           => array(
                            'true'          => 'page.admin.config.protected.choice.yes',
                            'false'         => 'page.admin.config.protected.choice.no'
                        )
                    )
                )
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'    => $this->class,
                'intention'     => 'page_config_form'
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
