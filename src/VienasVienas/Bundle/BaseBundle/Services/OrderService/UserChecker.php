<?php

/*
 * This file is part of the BaseBundle.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */

namespace VienasVienas\Bundle\BaseBundle\Services\OrderService;

use Doctrine\ORM\EntityManager;
use \VienasVienas\Bundle\BaseBundle\Entity\User;
use VienasVienas\Bundle\BooksBundle\Entity\Book;

/**
 * Class UserChecker checks user reservation and order statuses.
 *
 * @package VienasVienas\Bundle\BaseBundle\Services\OrderService
 */
class UserChecker
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
     * Method checks user reservations.
     *
     * @param Book $bookId
     * @param User $user
     *
     * @return bool
     */
    public function reservationUserFinder(Book $bookId, User $user)
    {
        $orders = $this->entityManager->getRepository('BaseBundle:Order')->findByBook($bookId);

        foreach ($orders as $order) {
            if ($order->getUser() == $user && $order->getStatus() == 'reserved') {
                return true;
            }
        }

        return false;
    }

    /**
     * Method checks user orders.
     *
     * @param Book $bookId
     * @param User $user
     *
     * @return bool
     */
    public function orderUserFinder(Book $bookId, User $user)
    {
        $orders = $this->entityManager->getRepository('BaseBundle:Order')->findByBook($bookId);

        foreach ($orders as $order) {
            if ($order->getUser() == $user && $order->getStatus() == 'active') {
                return true;
            }
        }

        return false;
    }

}
