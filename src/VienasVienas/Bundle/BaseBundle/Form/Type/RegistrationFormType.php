<?php

namespace VienasVienas\Bundle\BaseBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

/**
 * Class RegistrationFormType overrides FOSUserBundle Registration form.
 */
class RegistrationFormType extends BaseType
{
    /**
     * Overrides FOSUserBundle registration form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('username');
        $builder->remove('plainPassword');
        $builder->add(
            'plainPassword', 'password', array(
            'label' => 'Password:',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'base_user_registration';
    }
}