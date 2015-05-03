<?php

/*
 * This file is part of the BaseBundle.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */

namespace VienasVienas\Bundle\BaseBundle\Services\OrderService;

use Doctrine\ORM\EntityManager;
use VienasVienas\Bundle\BaseBundle\Entity\Order;
use \VienasVienas\Bundle\BooksBundle\Entity\Book;
use VienasVienas\Bundle\BaseBundle\Entity\User;

/**
 * Class Reservation.
 *
 * @package VienasVienas\Bundle\BaseBundle\Services\OrderService
 */
class Reservation
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Method flush new order into database.
     *
     * @param Book $bookEntity
     * @param User $userEntity
     * @param null $pickupDate
     */
    public function makeReservation(Book $bookEntity, User $userEntity, $pickupDate = null)
    {
        $order = new Order();
        $order->setUser($userEntity);
        $order->setBook($bookEntity);
        $order->setPickupDate($pickupDate);
        $order->setReservationDate(new \DateTime('now'));
        $order->setStatus('reserved');

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}
