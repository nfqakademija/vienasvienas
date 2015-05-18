<?php

namespace  VienasVienas\Bundle\BaseBundle\Services\AuthSuccessHandler;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class AuthSuccessHandler custom methods for authentication successes and fails.
 *
 * @package VienasVienas\Bundle\BaseBundle\Services\AuthSuccessHandler
 */
class AuthenticationHandler implements
    AuthenticationSuccessHandlerInterface,
    AuthenticationFailureHandlerInterface,
    LogoutSuccessHandlerInterface
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Redirects to homepage then authentication succeeded.
     *
     * @param Request        $request
     * @param TokenInterface $token
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $referrer = $request->getSession()->get('_security.secure_area.target_path');

        if (empty($referrer)) {
            return new RedirectResponse($this->router->generate('books_homepage'));
        } else {
            return new RedirectResponse($referrer);
        }
    }

    /**
     * Redirects to login page then authentication fails.
     *
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return RedirectResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $error = $exception->getMessage();

        $request->getSession()->set('login_error', $error);

        return new \Symfony\Component\HttpFoundation\RedirectResponse($this->router->generate('fos_user_security_login'));
    }

    /**
     * Redirects to login page then user logout.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function onLogoutSuccess(Request $request)
    {
        $referrer = $request->headers->get('referrer');
        if (empty($referrer)) {
            return new RedirectResponse($this->router->generate('fos_user_security_login'));
        } else {
            return new RedirectResponse($referrer);
        }
    }
}
