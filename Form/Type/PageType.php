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
     * @param string              $class
     */
    public function __construct($class)
    {
        $this->class    = $class;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'label'         => 'page.admin.page.name.text',
                    'required'      => true
                )
            )
            ->add('slug', 'text', array(
                    'label'         => 'page.admin.page.slug.text',
                    'required'      => false
                )
            )
            ->add('description', 'textarea', array(
                    'label'         => 'page.admin.page.description.text',
                    'required'      => false,
                    'attr'          => array(
                        'class'         => 'tinymce',
                        'data-theme'    => 'advanced'
                    )
                )
            )
            ->add('text', 'textarea', array(
                    'label'         => 'page.admin.page.text.text',
                    'attr'          => array(
                        'class'         => 'tinymce',
                        'data-theme'    => 'advanced'
                    )
                )
            )
            ->add('author', 'text', array(
                    'label'         => 'page.admin.page.author.text',
                    'required'      => true
                )
            )
            ->add('image', 'file', array(
                    'label'         => 'page.admin.page.image.text',
                    'required'      => false
                )
            )
            ->add('status', 'black_page_choice_list_status', array(
                    'label'         => 'page.admin.page.status.text',
                    'empty_value'   => 'page.admin.page.status.empty',
                    'required'      => true
                )
            )
            ->add('enabled', 'black_page_choice_list_enabled', array(
                    'label'         => 'page.admin.page.enabled.text',
                    'empty_value'   => 'page.admin.page.enabled.empty',
                    'required'      => true
                )
            )
            ->add('datePublished', 'date', array(
                    'label'         => 'page.admin.page.datePublished.text',
                    'years'         => array_reverse(
                        range(2000, date('Y', strtotime('now')))
                    ),
                    'required'      => true,
                    'empty_value'   => array(
                        'year'  => 'page.admin.page.datePublished.choice.year.text',
                        'month' => 'page.admin.page.datePublished.choice.month.text',
                        'day'   => 'page.admin.page.datePublished.choice.day.text')
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
