<?php

namespace VienasVienas\Bundle\BaseBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('username');
        $builder->remove('plainPassword');
        $builder->add('plainPassword', 'password', array(
        'label' => 'Password',
    ));
    }

    public function getName()
    {
        return 'base_user_registration';
    }
}