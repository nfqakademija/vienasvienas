<?php

/*
 * This file is part of the BaseBundle.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */

namespace VienasVienas\Bundle\BaseBundle\Services\NotificationService;

use VienasVienas\Bundle\BaseBundle\Entity\Order;
use VienasVienas\Bundle\BaseBundle\Entity\User;

/**
 * Class NotificationService sends notifications for users.
 *
 * @package VienasVienas\Bundle\BaseBundle\Services\NotificationService
 */
class NotificationService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Sends email to user with confirmation links.
     *
     * @param Order  $order
     * @param User   $user
     * @param string $token
     */
    public function send(Order $order, User $user, $token)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject(
                'You order confirmation, book: '
                . $order->getBook()->getAuthor() . ' '
                . $order->getBook()->getTitle() . ' '
            )
            ->setFrom('infovienasvienas@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                'You can order your book within 24 hours from receiving this message<br>
                by click on link below or by ordering directly from page:<br>
                <a href="http://vilnius1.projektai.nfqakademija.lt/book/' . $order->getBook()->getId() . '">
                vilnius1.projektai.nfqakademija.lt/book/' . $order->getBook()->getId() . '</a><br>
                 Order confirmation link:<br>
                <a href="http://vilnius1.projektai.nfqakademija.lt/order/update/' . $order->getBook()->getId() . '/' . $token . '">
                vilnius1.projektai.nfqakademija.lt/order/update/' . $order->getBook()->getId() . '/' . $token . '</a><br>
                Order rejecting link:<br>
                <a href="vilnius1.projektai.nfqakademija.lt/order/delete/' . $order->getBook()->getId() . '/' . $token . '">
                vilnius1.projektai.nfqakademija.lt/order/delete/' . $order->getBook()->getId() . '/' . $token . '</a>',
                'text/html'
            );
        $this->mailer->send($message);
    }

    /**
     * Sends informational email about order cancellation.
     *
     * @param Order $order
     * @param User  $user
     */
    public function sendCancellation(Order $order, User $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject(
                'You order cancellation, book: '
                . $order->getBook()->getAuthor() . ' '
                . $order->getBook()->getTitle() . ' '
            )
            ->setFrom('infovienasvienas@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                'You order was cancelled because you don\'t confirm it within 24 hours<br>
                Book: '
                . $order->getBook()->getAuthor() . ' '
                . $order->getBook()->getTitle() . ' ',
                'text/html'
            );
        $this->mailer->send($message);
    }
}
