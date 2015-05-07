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
                . $order->getBook()->getTitle() . ' '
                . $order->getBook()->getAuthor() .' '
            )
            ->setFrom('valdemar.karasevic@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                'You can order your book within 24 hours from receiving this message<br>
                by click on link below or by ordering directly from page:<br>
                <a href="www.nfqakademija.dev/book/list/' . $order->getBook()->getId() . '">
                www.nfqakademija.dev/book/list/' . $order->getBook()->getId() . '</a><br>
                 Order confirmation link:<br>
                <a href="www.nfqakademija.dev/order/update/' . $order->getBook()->getId() . '/' . $token . '">
                www.nfqakademija.dev/order/update/' . $order->getBook()->getId() . '/' . $token . '</a><br>
                Order rejecting link:<br>
                <a href="www.nfqakademija.dev/order/delete/' . $order->getBook()->getId() . '/' . $token . '">
                www.nfqakademija.dev/order/delete/' . $order->getBook()->getId() . '/' . $token . '</a>',
                'text/html'
            );
        $this->mailer->send($message);
    }
}
