<?php
/**
 * Created by PhpStorm.
 * User: destas
 * Date: 5/6/15
 * Time: 8:20 PM
 */

namespace VienasVienas\Bundle\BaseBundle\Services\NotificationService;


use Doctrine\ORM\EntityManager;
use VienasVienas\Bundle\BooksBundle\Entity\Book;

class TokenSetter
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    protected $notification;

    protected $generator;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager, NotificationService $notification, TokenGenerator $generator
    )
    {
        $this->entityManager = $entityManager;
        $this->notification = $notification;
        $this->generator = $generator;
    }

    public function setTokenToUser(Book $book)
    {
        $tokenDate = new \DateTime('now');
        $dateToString = $tokenDate->format('Y-m-d H:i:s');
        $token = $this->generator->generateToken($dateToString);
        $reservation = $this->entityManager->getRepository('BaseBundle:Order')->findByMinReservationDate($book);
        $reservation->setReservationDate(null);
        $reservation->setToken($token);
        $reservation->setTokenDate($tokenDate);
        $user = $reservation->getUser();

        $this->entityManager->flush();

        $this->notification->send($reservation, $user, $token);
    }
}
