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
     * @var type 
     */
    protected $class;

    /**
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                    'label' => 'black.bundle.page.type.webpage.name.label',
                    'required' => true,
                ]
            )
            ->add('slug', 'text', [
                    'label' => 'black.bundle.page.type.webpage.slug.label',
                    'required' => false,
                ]
            )

            ->add('headline', 'textarea', [
                    'label' => 'black.bundle.page.type.webpage.headline.label',
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
            )

            ->add('image', 'file', [
                    'label' => 'black.bundle.page.type.webpage.image.label',
                    'required' => false,
                ]
            )

            ->add('author', 'text', [
                    'label' => 'black.bundle.page.type.webpage.author.label',
                    'required' => true,
                ]
            )
            ->add('publication', 'black_page_choice_list_status', [
                    'label' => 'black.bundle.page.type.webpage.publication.label',
                    'empty_value' => 'black.bundle.page.type.webpage.publication.empty',
                    'required' => true,
                ]
            )
            ->add('datePublished', 'date', [
                    'label' => 'black.bundle.page.type.webpage.datePublished.label',
                    'widget' => 'single_text',
                    'years' => array_reverse(
                        range(2000, date('Y', strtotime('now')))
                    ),
                    'required' => true,
                    'empty_value' => [
                        'year' => 'black.bundle.page.type.webpage.datePublished.choice.year.label',
                        'month' => 'black.bundle.page.type.webpage.datePublished.choice.month.label',
                        'day' => 'black.bundle.page.type.webpage.datePublished.choice.day.label',
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
        return 'black_page_webpage';
    }
}