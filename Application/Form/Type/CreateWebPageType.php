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
 * Class CreateWebPageType
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CreateWebPageType extends AbstractType
{
    /**
     * @var type 
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
            ->add('name', 'text', [
                    'label'  => 'black.bundle.page.domain.form.type.webpage.name.label',
                    'required' => true,
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
                            null,
                            $form->get('name')->getData()
                        );
                    },
                'intention' => 'create_webpage_form',
                'translation_domain' => 'form',
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
