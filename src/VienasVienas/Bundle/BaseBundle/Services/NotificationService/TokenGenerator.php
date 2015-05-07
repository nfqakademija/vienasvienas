<?php

/*
 * This file is part of the BaseBundle.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */

namespace VienasVienas\Bundle\BaseBundle\Services\NotificationService;

/**
 * Class TokenGenerator generates unique token for order confirmation by an email.
 *
 * @package VienasVienas\Bundle\BaseBundle\Services\NotificationService
 */
class TokenGenerator
{
    /**
     * @var string
     */
    protected $token;

    /**
     * Generates unique token.
     *
     * @param \DateTime $returnDate
     *
     * @return string
     */
    public function generateToken($returnDate)
    {
        $this->token = sha1(uniqid($returnDate, true));

        return $this->token;
    }
}
