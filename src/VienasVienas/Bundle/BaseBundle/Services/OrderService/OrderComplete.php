<?php

/*
 * This file is part of the BaseBundle.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */

namespace VienasVienas\Bundle\BaseBundle\Services\OrderService;

use VienasVienas\Bundle\BaseBundle\Entity\Order;
use VienasVienas\Bundle\BaseBundle\Entity\User;
use VienasVienas\Bundle\BooksBundle\Entity\Book;
use Doctrine\ORM\EntityManager;

/**
 * Class OrderComplete class for completing orders.
 *
 * @package VienasVienas\Bundle\BaseBundle\Services\OrderService
 */
class OrderComplete
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
     * Method for updating database after completing an order.
     *
     * @param Book $bookEntity
     * @param User $userId
     */
    public function returnOrder(Book $bookEntity, User $userId)
    {
        $dq = $this->entityManager->createQueryBuilder('o')
            ->update('BaseBundle:Order', 'o')
            ->set('o.status', ':status')
            ->where('o.book = :id')
            ->andWhere('o.user = :user')
            ->andWhere('o.status = \'active\'')
            ->setParameter('status', 'done')
            ->setParameter('id', $bookEntity)
            ->setParameter('user', $userId)
            ->getQuery();

        $dq->execute();

        $quantity = $bookEntity->getQuantity();

        $bookEntity->setQuantity($quantity + 1);

        $this->entityManager->persist($bookEntity);
        $this->entityManager->flush();
    }
}