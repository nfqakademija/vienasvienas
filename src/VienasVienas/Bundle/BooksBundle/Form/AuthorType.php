<?php

namespace VienasVienas\Bundle\BooksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('author');

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VienasVienas\Bundle\BooksBundle\Entity\Author',
        ));
    }

    public function getName()
    {
        return 'vienasvienas_bundle_booksbundle_author';
    }
}
