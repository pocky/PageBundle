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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class WriteWebPageType
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class WriteWebPageType extends AbstractType
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

            ->add('headline', 'text', [
                    'label' => 'black.bundle.page.domain.form.type.webpage.headline.label',
                    'required' => false,
                ]
            )

            ->add('about', 'textarea', [
                    'label' => 'black.bundle.page.domain.form.type.webpage.about.label',
                    'required' => false,
                ]
            )

            ->add('text', 'textarea', [
                    'label' => 'black.bundle.page.domain.form.type.webpage.text.label',
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
                'empty_data' => function (FormInterface $form) {
                    return new $this->class(
                        $form->get('id')->getData(),
                        $form->get('headline')->getData(),
                        $form->get('about')->getData(),
                        $form->get('text')->getData()
                    );
                },
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
