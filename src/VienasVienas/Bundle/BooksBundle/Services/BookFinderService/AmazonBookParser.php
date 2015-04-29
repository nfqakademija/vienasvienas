<?php

namespace VienasVienas\Bundle\BooksBundle\Services\BookFinderService;

use VienasVienas\Bundle\BooksBundle\Entity\Author;
use VienasVienas\Bundle\BooksBundle\Entity\Book;

/**
 * Class AmazonBookParser
 * @package VienasVienas\Bundle\BooksBundle
 */
class AmazonBookParser
{
    /**
     * @var Book entity
     */
    private $book;
    /**
     * @var Author
     */
    private $author;
    /**
     * @param Book $book
     * @param Author $author
     */
    public function __construct(Book $book, Author $author)
    {
        $this->book = $book;
        $this->author = $author;
    }

    /**
     * @param object $content
     * @return Book $book
     */
    public function parseBook($content)
    {
        if ($this->checkContent($content)) {
            $author = $this->parseAuthor($content);
            $this->author->setAuthor($author);

            $this->book->setAuthor($this->author);
            $title = $this->parseTitle($content);
            $this->book->setTitle($title);

            $about = $this->parseAbout($content);
            $this->book->setAbout($about);

            $pages = $this->parsePageCount($content);
            $this->book->setPages($pages);

            $cover = $this->parseCover($content);
            $this->book->setCover($cover);

            $isbn = $this->parseIsbn($content);
            $this->book->setIsbn($isbn);

            $rating = $this->parseRating();
            $this->book->setRating($rating);

            $date = new \DateTime();
            $this->book->setRegistrationDate($date);

            return $this->book;
        } else {
            return $this->book;
        }
    }

    /**
     * @param $content
     * @return string
     */
    private function parseAuthor($content)
    {
        $author = (string)$content->Items->Item->ItemAttributes->Author;
        if (isset($author)) {
            return $author;
        } else {
            return 0;
        }
    }
    /**
     * @param $content
     * @return string
     */
    private function parseTitle($content)
    {
        return (string)$content->Items->Item->ItemAttributes->Title;
    }

    /**
     * @param $content
     * @return string
     */
    private function parseAbout($content)
    {
        if (!isset($content->Items->Item->EditorialReviews->EditorialReview->Content)) {
            return "";
        } else {
            return (string)$content->Items->Item->EditorialReviews->EditorialReview->Content;
        }
    }

    /**
     * @param $content
     * @return integer
     */
    private function parsePageCount($content)
    {
        return (integer)$content->Items->Item->ItemAttributes->NumberOfPages;
    }


    /**
     * @param $content
     * @return string
     */
    private function parseCover($content)
    {
        return '<img src="'. (string)$content->Items->Item->MediumImage->URL .'">';
    }

    /**
     * @param $content
     * @return string
     */
    private function parseIsbn($content)
    {
        return (string)$content->Items->Item->ItemAttributes->EAN;
    }

    /**
     * @return float
     */
    private function parseRating()
    {
        //return number, because Amazon API removed support for accessing rating information in 2010
        return "0";
    }

    /**
     * @param $content
     * @return bool
     */
    private function checkContent($content)
    {
        if (!isset($content->Items)) {
            return false;
        } else {
            return true;
        }
    }
}
