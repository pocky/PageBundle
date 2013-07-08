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
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    private $class;
    private $enabled;
    private $status;

    /**
     * @param $class
     * @param ChoiceListInterface $enabled
     * @param ChoiceListInterface $status
     */
    public function __construct($class, ChoiceListInterface $enabled, ChoiceListInterface $status)
    {
        $this->class    = $class;
        $this->enabled  = $enabled;
        $this->status   = $status;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'label'         => 'page.admin.page.name.text'
                )
            )
            ->add('slug', 'text', array(
                    'label'         => 'page.admin.page.slug.text',
                    'required'      => false
                )
            )
            ->add('description', 'textarea', array(
                    'label'         => 'page.admin.page.description.text',
                    'required'      => false
                )
            )
            ->add('text', 'ckeditor', array(
                    'label'         => 'page.admin.page.text.text',
                    'filebrowser_image_browse_url' => array(
                        'route'            => 'elfinder',
                        'route_parameters' => array(),
                    ),
                )
            )
            ->add('author', 'text', array(
                    'label'         => 'page.admin.page.author.text',
                    'required'      => false
                )
            )
            ->add('image', 'file', array(
                    'label'         => 'page.admin.page.image.text',
                    'required'      => false
                )
            )
            ->add('status', 'choice', array(
                    'label'         => 'page.admin.page.status.text',
                    'empty_value'   => 'page.admin.page.status.empty',
                    'choice_list'   => $this->status
                ))
            ->add('enabled', 'choice', array(
                    'label'         => 'page.admin.page.enabled.text',
                    'empty_value'   => 'page.admin.page.enabled.empty',
                    'choice_list'   => $this->enabled
                )
            )
            ->add('datePublished', 'date', array(
                    'label'         => 'page.admin.page.datePublished.text',
                    'years'         => array_reverse(
                        range(2000, date('Y', strtotime('now')))
                    ),
                    'required'      => false,
                    'empty_value'   => array(
                        'year' => 'page.admin.page.year.datePublished.choice.text',
                        'month' => 'page.admin.page.month.datePublished.choice.text',
                        'day' => 'page.admin.page.datePublished.choice.day.text')
                )
            )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class'    => $this->class,
                'intention'     => 'page_form'
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_page_page';
    }
}
