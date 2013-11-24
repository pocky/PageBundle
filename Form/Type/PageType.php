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
 * Class PageType
 *
 * @package Black\Bundle\PageBundle\Form\Type
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class PageType extends AbstractType
{
    /**
     * @var type 
     */
    protected $class;

    /**
     * @var \Symfony\Component\EventDispatcher\EventSubscriberInterface
     */
    protected $eventSubscriber;

    /**
     * @param                          $class
     * @param EventSubscriberInterface $eventSubscriber
     */
    public function __construct($class, EventSubscriberInterface $eventSubscriber)
    {
        $this->class            = $class;
        $this->eventSubscriber  = $eventSubscriber;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->eventSubscriber);

        $builder
            ->add('name', 'text', array(
                    'label'         => 'black.bundle.page.type.page.name.label',
                    'required'      => true
                )
            )
            ->add('slug', 'text', array(
                    'label'         => 'black.bundle.page.type.page.slug.label',
                    'required'      => false
                )
            )
            ->add('description', 'textarea', array(
                    'label'         => 'black.bundle.page.type.page.description.label',
                    'required'      => false
                )
            )
            ->add('text', 'textarea', array(
                    'label'         => 'black.bundle.page.type.page.text.label',
                    'attr'          => array(
                        'class'         => 'tinymce',
                        'data-theme'    => 'advanced'
                    )
                )
            )
            ->add('author', 'text', array(
                    'label'         => 'black.bundle.page.type.page.author.label',
                    'required'      => true
                )
            )
            /*->add('image', 'file', array(
                    'label'         => 'black.bundle.page.type.page.image.label',
                    'required'      => false
                )
            )*/
            ->add('status', 'black_page_choice_list_status', array(
                    'label'         => 'black.bundle.page.type.page.status.label',
                    'empty_value'   => 'black.bundle.page.type.page.status.empty',
                    'required'      => true
                )
            )
            ->add('enabled', 'black_page_choice_list_enabled', array(
                    'label'         => 'black.bundle.page.type.page.enabled.label',
                    'empty_value'   => 'black.bundle.page.type.page.enabled.empty',
                    'required'      => true
                )
            )
            ->add('datePublished', 'date', array(
                    'label'         => 'black.bundle.page.type.page.datePublished.label',
                    'widget'        => 'single_text',
                    'years'         => array_reverse(
                        range(2000, date('Y', strtotime('now')))
                    ),
                    'required'      => true,
                    'empty_value'   => array(
                        'year'  => 'black.bundle.page.type.page.datePublished.choice.year.text',
                        'month' => 'black.bundle.page.type.page.datePublished.choice.month.text',
                        'day'   => 'black.bundle.page.type.page.datePublished.choice.day.text')
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
                'intention'             => 'page_form',
                'translation_domain'    => 'form'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_page_page';
    }
}
