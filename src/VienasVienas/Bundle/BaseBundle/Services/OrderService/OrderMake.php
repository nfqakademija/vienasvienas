<?php

/*
 * This file is part of the BaseBundle.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */

namespace VienasVienas\Bundle\BaseBundle\Services\OrderService;

use Symfony\Component\Config\Definition\Exception\Exception;
use VienasVienas\Bundle\BaseBundle\Entity\Order;
use Doctrine\ORM\EntityManager;
use VienasVienas\Bundle\BooksBundle\Entity\Book;
use VienasVienas\Bundle\BaseBundle\Entity\User;

/**
 * Class OrderMaker flush new orders into database.
 *
 * @package VienasVienas\Bundle\BaseBundle\Services\OrderService
 */
class OrderMake
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
     * Method for flushing new orders into database.
     *
     * @param Book $bookEntity
     * @param User $userEntity
     * @param null $reservationDate
     *
     * @throws Exception No enough books exception
     */
    public function makeOrder(Book $bookEntity, User $userEntity, $reservationDate = null)
    {
        $order = new Order();
        $order->setUser($userEntity);
        $order->setBook($bookEntity);
        $order->setPickupDate(new \DateTime());
        $order->setReservationDate($reservationDate);
        $order->setStatus('active');
        $returnDate = new \DateTime();
        $returnDate->modify('+ 30 days');
        $order->setReturnDate($returnDate);


        $quantity = $bookEntity->getQuantity();
        if ($quantity == 0) {
            throw new Exception('There is no enough books');
        }
        $bookEntity->setQuantity($quantity - 1);

        $this->entityManager->persist($order);
        $this->entityManager->persist($bookEntity);
        $this->entityManager->flush();
    }
}
