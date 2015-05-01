<?php

namespace VienasVienas\Bundle\BooksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Author
 *
 * @ORM\Table(name="authors")
 * @ORM\Entity
 */
class Author
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
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="Book", mappedBy="author")
     **/
    private $books;

    /**
     *
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
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
     * Set Author
     *
     * @param string $author
     * @return Author
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return (string) $this;
    }

    /**
     * Get Author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add books
     *
     * @param \VienasVienas\Bundle\BooksBundle\Entity\Book $books
     * @return Author
     */
    public function addBook(Book $books)
    {
        $this->books[] = $books;

        return $this;
    }

    /**
     * Remove books
     *
     * @param \VienasVienas\Bundle\BooksBundle\Entity\Book $book
     */
    public function removeBook(Book $book)
    {
        $this->books->removeElement($book);
    }

    /**
     * Get books
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->author;
    }
}
