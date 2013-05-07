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
     * @param string $class The Person class name
     */
    public function __construct($class, ChoiceListInterface $enabled, ChoiceListInterface $status)
    {
        $this->class    = $class;
        $this->enabled  = $enabled;
        $this->status   = $status;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'label'         => 'page.admin.form.name'
                )
            )
            ->add('slug', 'text', array(
                    'label'         => 'page.admin.form.slug',
                    'required'      => false
                )
            )
            ->add('description', 'textarea', array(
                    'label'         => 'page.admin.form.description',
                    'required'      => false
                )
            )
            ->add('text', 'ckeditor', array(
                    'label'         => 'page.admin.form.text',
                    'filebrowser_image_browse_url' => array(
                        'route'            => 'elfinder',
                        'route_parameters' => array(),
                    ),
                )
            )
            ->add('author', 'text', array(
                    'label'         => 'page.admin.form.author',
                    'required'      => false
                )
            )
            ->add('image', 'file', array(
                    'label'         => 'page.admin.form.image',
                    'required'      => false
                )
            )
            ->add('status', 'choice', array(
                    'label'         => 'page.admin.form.status.label',
                    'empty_value'   => 'page.admin.form.status.empty',
                    'choice_list'   => $this->status
                ))
            ->add('enabled', 'choice', array(
                    'label'         => 'page.admin.form.enabled.label',
                    'empty_value'   => 'page.admin.form.enabled.empty',
                    'choice_list'   => $this->enabled
                )
            )
            ->add('datePublished', 'date', array(
                    'label'         => 'page.admin.form.datePublished',
                    'years'         => array_reverse(
                        range(2000, date('Y', strtotime('now')))
                    ),
                    'required'      => false,
                    'empty_value'   => array('year' => 'admin.year', 'month' => 'admin.month', 'day' => 'admin.day')
                )
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class'    => $this->class,
                'intention'     => 'page_form'
            ));
    }

    public function getName()
    {
        return 'black_page_page';
    }
}
