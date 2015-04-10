<?php

namespace VienasVienas\Bundle\BooksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BooksType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('author')
            ->add('pages')
            ->add('isbn')
            ->add('rating')
            ->add('about')
            ->add('cover')
            ->add('registrationDate')
            ->add('categoryId')
            ->add('isAvailable')
            ->add('Save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VienasVienas\Bundle\BooksBundle\Entity\Books'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vienasvienas_bundle_booksbundle_books';
    }
}
