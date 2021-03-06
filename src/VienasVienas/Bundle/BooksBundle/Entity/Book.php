<?php

namespace VienasVienas\Bundle\BooksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use VienasVienas\Bundle\BaseBundle\Entity\Order;

/**
 * Book Entity.
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="VienasVienas\Bundle\BooksBundle\Entity\BookRepository")
 */
class Book
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var Order
     *
     * @ORM\OneToMany(targetEntity="VienasVienas\Bundle\BaseBundle\Entity\Order", mappedBy="book")
     * @ORM\JoinColumn(onDelete="CASCADE")
     **/
    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity="Author", inversedBy="books", cascade={"persist"})
     *
     **/

    private $author;

    /**
     * @var integer
     *
     * @ORM\Column(name="pages", type="integer")
     */
    private $pages;

    /**
     * @var string
     *
     * @ORM\Column(name="isbn", type="string", length=15)
     */
    private $isbn;

    /**
     * @var string
     *
     * @ORM\Column(name="rating", type="float")
     */
    private $rating;

    /**
     * @var string
     *
     * @ORM\Column(name="about", type="text")
     */
    private $about;

    /**
     * @var string
     *
     * @ORM\Column(name="cover", type="string", length=1000)
     */
    private $cover;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_date", type="date")
     */
    private $registrationDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity = 1;

    /**
     * @var integer
     *
     * @ORM\Column(name="times_read", type="integer")
     */
    private $timesRead = 0;


    /**
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(name="books_categories",
     *      joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="categories_id", referencedColumnName="id")}
     *      )
     **/
    private $categories;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set pages
     *
     * @param integer $pages
     * @return Book
     */
    public function setPages($pages)
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * Get pages
     *
     * @return integer
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set isbn
     *
     * @param string $isbn
     * @return Book
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn.
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set rating
     *
     * @param string $rating
     * @return Book
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set about
     *
     * @param string $about
     * @return Book
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set cover
     *
     * @param string $cover
     * @return Book
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     * @return Book
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set isAvailable
     *
     * @param integer $quantity
     * @return Book
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Add categories.
     *
     * @param \VienasVienas\Bundle\BooksBundle\Entity\Category $category
     */
    public function addCategory(\VienasVienas\Bundle\BooksBundle\Entity\Category $category)
    {
        $category->addBook($this);
        $this->categories[] = $category;
    }

    /**
     * Remove category.
     *
     * @param \VienasVienas\Bundle\BooksBundle\Entity\Category $category
     */
    public function removeCategory(\VienasVienas\Bundle\BooksBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set author
     *
     * @param \VienasVienas\Bundle\BooksBundle\Entity\Author $author
     * @return Book
     */
    public function setAuthor(Author $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \VienasVienas\Bundle\BooksBundle\Entity\Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add orders
     *
     * @param \VienasVienas\Bundle\BaseBundle\Entity\Order $orders
     * @return Book
     */
    public function addOrder(\VienasVienas\Bundle\BaseBundle\Entity\Order $orders)
    {
        $this->orders[] = $orders;

        return $this;
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

    /**
     * Get orders.
     *
     * @return Order
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @return int
     */
    public function getTimesRead()
    {
        return $this->timesRead;
    }

    /**
     * @param int $timesRead
     */
    public function setTimesRead($timesRead)
    {
        $this->timesRead = $timesRead;
    }
}