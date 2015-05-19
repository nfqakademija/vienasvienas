<?php

/*
 * This file is part of the BaseBundle package.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */

namespace VienasVienas\Bundle\BaseBundle\Services\NotificationService;


use Doctrine\ORM\EntityManager;
use VienasVienas\Bundle\BooksBundle\Entity\Book;

/**
 * Class TokenSetter sets token to user.
 */
class TokenSetter
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var NotificationService
     */
    protected $notification;

    /**
     * @var TokenGenerator
     */
    protected $generator;

    /**
     * @param EntityManager       $entityManager
     * @param NotificationService $notification
     * @param TokenGenerator      $generator
     */
    public function __construct(
        EntityManager $entityManager,
        NotificationService $notification,
        TokenGenerator $generator
    ) {
        $this->entityManager = $entityManager;
        $this->notification = $notification;
        $this->generator = $generator;
    }

    /**
     * @param Book $book
     */
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
