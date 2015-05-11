<?php

namespace VienasVienas\Bundle\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data)
    {
        $form = $this->createFormBuilder($data)
            ->setAction($this->generateUrl('fos_user_security_check'))
            ->add('email', 'text', array(
                'data' => $data['last_username'],
                'required' => true,
            ))
            ->add('password', 'password', array(
                'required' => true,
            ))
            ->add('remember_me', 'checkbox', array(
                'required' => false,
            ))
            ->add('Login', 'submit')
            ->getForm();

        return $this->render('FOSUserBundle:Security:login.html.twig', array(
            'form' => $form->createView(),
            'error' => $data['error'],
        ));
    }
}
