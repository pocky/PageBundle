<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PageBundle\Application\Form\Type;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class WebPageType
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WebPageType extends AbstractType
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var
     */
    protected $name;

    /**
     * @param $class
     * @param $name
     */
    public function __construct($class, $name)
    {
        $this->class = $class;
        $this->name  = $name;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
            ->add('name', 'text', [
                    'label' => 'black.bundle.page.type.webpage.name.label',
                    'required' => true,
                ]
            )

            ->add('headline', 'textarea', [
                    'label' => 'black.bundle.page.type.webpage.headline.label',
                    'required' => false,
                ]
            )

            ->add('about', 'textarea', [
                    'label' => 'black.bundle.page.type.webpage.about.label',
                    'required' => false,
                ]
            )

            ->add('text', 'textarea', [
                    'label' => 'black.bundle.page.type.webpage.text.label',
                    'attr' => [
                        'class' => 'tinymce',
                        'data-theme' => 'advanced',
                    ],
                ]
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => $this->class,
                'empty_data' => function(FormInterface $form) {
                        return new $this->class(
                            $form->get('id')->getData(),
                            $form->get('name')->getData(),
                            $form->get('headline')->getData(),
                            $form->get('about')->getData(),
                            $form->get('text')->getData()
                        );
                    },
                'intention' => 'webpage_form',
                'translation_domain' => 'form'
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
