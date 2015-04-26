<?php

namespace VienasVienas\Bundle\BooksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use VienasVienas\Bundle\BooksBundle\Form\DataTransformer\AuthorToStringTransformer;


class BookType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $entityManager = $options['em'];
        $transformer = new AuthorToStringTransformer($entityManager);

        $builder
            ->add(
                $builder->create('author', 'text')
                ->addModelTransformer($transformer)
            )
            ->add('title')
            ->add('pages')
            ->add('isbn')
            ->add('rating')
            ->add('about')
            ->add('cover')
            ->add('registrationDate')
            ->add('categories')
            ->add('quantity');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VienasVienas\Bundle\BooksBundle\Entity\Book',
        ))
            ->setRequired(array('em'))
            ->setAllowedTypes('em', 'Doctrine\Common\Persistence\ObjectManager');

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vienasvienas_bundle_booksbundle_book';
    }
}
