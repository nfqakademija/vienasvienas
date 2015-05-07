<?php

/*
 * This file is part of the BaseBundle.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */

namespace VienasVienas\Bundle\BaseBundle\Services\NotificationService;

use Doctrine\ORM\EntityManager;
use VienasVienas\Bundle\BaseBundle\Entity\Order;

/**
 * Class TokenChecker checks is token expired or not.
 *
 * @package VienasVienas\Bundle\BaseBundle\Services\NotificationService
 */
class TokenChecker
{
    /**
     * 24 hours in seconds.
     */
    const DELTA = 86400;

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
     * Method for token checking.
     *
     * @param \DateTime $requestTime
     * @param Order     $orderEntity
     *
     * @return bool
     */
    public function checkToken($requestTime, Order $orderEntity)
    {
        $orderReturnDate = $orderEntity->getTokenDate();
        $returnTimestamp = $orderReturnDate->getTimestamp();

        if ($requestTime - $returnTimestamp > static::DELTA) {
            return false;
        }

        return true;
    }
}
