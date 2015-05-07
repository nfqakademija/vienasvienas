<?php

namespace VienasVienas\Bundle\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="VienasVienas\Bundle\BaseBundle\Entity\OrderRepository")
 */
class Order
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="VienasVienas\Bundle\BooksBundle\Entity\Book", inversedBy="orders",
     * cascade={"persist"})
     * JoinColumn(name="book_id", referencedColumnName="id")
     **/
    private $book;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pickup_date", type="datetime", nullable=true)
     */
    private $pickupDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="return_date", type="datetime", nullable=true)
     */
    private $returnDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservation_date", type="datetime", nullable=true)
     */
    private $reservationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    /** @ORM\Column(type="string")
     */
    private $status;

    /** @ORM\Column(type="string", nullable=true)
     */
    private $token;

    /** @ORM\Column(name="token_date", type="datetime", nullable=true)
     */
    private $tokenDate;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pickupDate
     *
     * @param \DateTime $pickupDate
     * @return Order
     */
    public function setPickupDate($pickupDate)
    {
        $this->pickupDate = $pickupDate;

        return $this;
    }

    /**
     * Get pickupDate
     *
     * @return \DateTime 
     */
    public function getPickupDate()
    {
        return $this->pickupDate;
    }

    /**
     * Set returnDate
     *
     * @param \DateTime $returnDate
     * @return Order
     */
    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    /**
     * Get returnDate
     *
     * @return \DateTime 
     */
    public function getReturnDate()
    {
        return $this->returnDate;
    }

    /**
     * Set reservationDate
     *
     * @param \DateTime $reservationDate
     * @return Order
     */
    public function setReservationDate($reservationDate)
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }

    /**
     * Get reservationDate
     *
     * @return \DateTime 
     */
    public function getReservationDate()
    {
        return $this->reservationDate;
    }

    /**
     * Set User
     *
     * @param \VienasVienas\Bundle\BaseBundle\Entity\User $user
     * @return Order
     */
    public function setUser(\VienasVienas\Bundle\BaseBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get User
     *
     * @return \VienasVienas\Bundle\BaseBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set book
     *
     * @param \VienasVienas\Bundle\BooksBundle\Entity\Book $book
     * @return Order
     */
    public function setBook(\VienasVienas\Bundle\BooksBundle\Entity\Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \VienasVienas\Bundle\BooksBundle\Entity\Book 
     */
    public function getBook()
    {
        return $this->book;
    }
    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Order
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set tokenDate
     *
     * @param \DateTime $tokenDate
     * @return Order
     */
    public function setTokenDate($tokenDate)
    {
        $this->tokenDate = $tokenDate;

        return $this;
    }

    /**
     * Get tokenDate
     *
     * @return \DateTime 
     */
    public function getTokenDate()
    {
        return $this->tokenDate;
    }
}
