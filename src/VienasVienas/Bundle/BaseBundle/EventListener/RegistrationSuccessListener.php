<?php

namespace VienasVienas\Bundle\BaseBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class RegistrationConfirmListener responsible for redirecting Users after registration.
 */
class RegistrationSuccessListener implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @param UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'
        );
    }

    /**
     * @return RedirectResponse
     */
    public function onRegistrationSuccess(FormEvent $event)
    {
        $url = $this->router->generate('books_homepage');
        $event->setResponse(new RedirectResponse($url));

    }
}
