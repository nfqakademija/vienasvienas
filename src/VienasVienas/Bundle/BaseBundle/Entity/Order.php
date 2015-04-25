<?php

namespace VienasVienas\Bundle\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity
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
     * @ORM\OneToOne(targetEntity="VienasVienas\Bundle\BooksBundle\Entity\Book", inversedBy="order")
     **/
    private $book;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pickup_date", type="date")
     */
    private $pickupDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="return_date", type="date")
     */
    private $returnDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservation_date", type="datetime")
     */
    private $reservationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $userId;

    /**
     * Get id
     *
     * @return integer 
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
     * Set userId
     *
     * @param \VienasVienas\Bundle\BaseBundle\Entity\User $userId
     * @return Order
     */
    public function setUserId(\VienasVienas\Bundle\BaseBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \VienasVienas\Bundle\BaseBundle\Entity\User 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
