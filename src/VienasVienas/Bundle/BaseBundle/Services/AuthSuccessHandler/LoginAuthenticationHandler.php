<?php

/*
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 */

namespace VienasVienas\Bundle\BaseBundle\Services\AuthSuccessHandler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Translation\Translator;

/**
 * Class LoginAuthenticationHandler AJAX Authentication handler for FOSUserBundle login form.
 */
class LoginAuthenticationHandler implements
    AuthenticationFailureHandlerInterface,
    AuthenticationSuccessHandlerInterface
{
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @param Translator $translator
     * @param Router     $router
     */
    public function __construct(Translator $translator, Router $router)
    {
        $this->translator = $translator;
        $this->router = $router;
    }

    /**
     * Method returns json with route path.
     *
     * @param Request        $request
     * @param TokenInterface $token
     *
     * @return JsonResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $targetUrl = $request->getSession()->get('_security.secure_area.target_path');

        if ($targetUrl == null) {
            $targetUrl = $this->router->generate('books_homepage');
        }

        if ($request->isXmlHttpRequest()) {
            $result = array(
                'route' => $targetUrl,
            );

            return new JsonResponse($result);
        }
    }

    /**
     * Method returns json response with error message ir authentication fails.
     *
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return JsonResponse
     */
    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    ) {
        $result = array(
            'error' => true,
            'message' => $this->translator->trans($exception->getMessage(), array(), 'FOSUserBundle'),
            'route' => 'undefined',
        );

        return new JsonResponse($result);
    }
}
