<?php

/*
 * This file is part of the BaseBundle.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */

namespace VienasVienas\Bundle\BaseBundle\Services\OrderService;

use Doctrine\ORM\EntityManager;
use VienasVienas\Bundle\BaseBundle\Entity\User;
use VienasVienas\Bundle\BooksBundle\Entity\Book;

/**
 * Class OrderUpdate updates orders table after book returning.
 *
 * @package VienasVienas\Bundle\BaseBundle\Services\OrderService
 */
class OrderUpdate
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
     * Method for updating orders table.
     *
     * @param Book $bookEntity
     * @param User $userId
     */
    public function updateOrder(Book $bookEntity, User $userId)
    {
        $pickupDate = new \DateTime('now');

        $dq = $this->entityManager->createQueryBuilder()
            ->update('BaseBundle:Order', 'o')
            ->set('o.status', ':status')
            ->set('o.pickupDate', ':pickup_date')
            ->set('o.reservationDate', 'null')
            ->set('o.token', 'null')
            ->where('o.book = :id')
            ->andWhere('o.user = :user')
            ->andWhere('o.status = \'reserved\'')
            ->setParameter('status', 'active')
            ->setParameter('pickup_date', $pickupDate)
            ->setParameter('id', $bookEntity)
            ->setParameter('user', $userId)
            ->getQuery();

        $dq->execute();

        $quantity = $bookEntity->getQuantity();
        $timesRead = $bookEntity->getTimesRead();

        if ($quantity == 0) {
            throw new \Exception('There is no enough books');
        }

        $bookEntity->setQuantity($quantity - 1);
        $bookEntity->setTimesRead($timesRead + 1);

        $this->entityManager->persist($bookEntity);
        $this->entityManager->flush();
    }
}
