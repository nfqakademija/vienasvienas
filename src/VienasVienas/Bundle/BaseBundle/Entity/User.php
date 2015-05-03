<?php


namespace VienasVienas\Bundle\BaseBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\OneToMany(targetEntity="VienasVienas\Bundle\BaseBundle\Entity\Order", mappedBy="user")
     */
    protected $orders;


    public function __construct()
    {
        parent::__construct();
        $this->orders = new ArrayCollection();
    }

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
     * Add order
     *
     * @param Order $orders
     * @return User
     */
    public function addOrder(Order $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove order
     *
     * @param Order $orders
     */
    public function removeOrders(Order $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Remove orders
     *
     * @param \VienasVienas\Bundle\BaseBundle\Entity\Order $orders
     */
    public function removeOrder(\VienasVienas\Bundle\BaseBundle\Entity\Order $orders)
    {
        $this->orders->removeElement($orders);
    }
}
