<?php

namespace VienasVienas\Bundle\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VienasVienas\Bundle\BaseBundle\Entity\User;

/**
 * Controller for base template components.
 *
 * Class BaseController
 */
class BaseController extends Controller
{
    /**
     * Action for latest active Users ordered book.
     *
     * @param User $user
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function recentBookAction(User $user)
    {
        $message = false;
        $em = $this->getDoctrine()->getEntityManager();
        $recentBook = $em->getRepository('BaseBundle:Order')->getLatestActiveBook($user);
        if ($recentBook == null) {
            $message = true;
        }

        return $this->render(
            'BaseBundle:Base:recentBook.html.twig',
            array(
                'recentBook' => $recentBook,
                'message' => $message,
            ));
    }

    /**
     * Active for Users active reservations.
     *
     * @param User $user
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function activeReservationAction(User $user)
    {
        $message = false;
        $em = $this->getDoctrine()->getEntityManager();
        $reservedBook = $em->getRepository('BaseBundle:Order')->getActiveReservations($user);
        if ($reservedBook == null) {
            $message = true;
        }
        return $this->render(
            'BaseBundle:Base:activeReservation.html.twig',
            array(
                'reservedBook' => $reservedBook,
                'message' => $message,
            ));
    }
}