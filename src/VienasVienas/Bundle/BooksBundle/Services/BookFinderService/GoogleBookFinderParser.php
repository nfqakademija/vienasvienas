<?php
/*
 * This file is part of the BooksBundle package.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */
namespace VienasVienas\Bundle\BooksBundle\Services\BookFinderService;

use VienasVienas\Bundle\BooksBundle\Entity\Books;

/**
 * Class GoogleBookFinderParser
 * @package VienasVienas\Bundle\BooksBundle
 */
class GoogleBookFinderParser
{
    /**
     * @param Books $book
     */
    public function __construct(Books $book)
    {
        $this->book = $book;
    }

    /**
     * @param object $content
     * @return Books $book
     */
    public function parseBook($content)
    {
        $content = json_decode($content);

        if ($this->checkContent($content)) {
            $author = $this->parseAuthor($content);
            $this->book->setAuthor($author);

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

            $rating = $this->parseRating($content);
            $this->book->setRating($rating);

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
        $author = $content->items[0]->volumeInfo->authors[0];
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
        return $content->items[0]->volumeInfo->title;
    }

    /**
     * @param $content
     * @return string
     */
    private function parseAbout($content)
    {
        return $content->items[0]->volumeInfo->description;
    }

    /**
     * @param $content
     * @return integer
     */
    private function parsePageCount($content)
    {
        return $content->items[0]->volumeInfo->pageCount;
    }


    /**
     * @param $content
     * @return string
     */
    private function parseCover($content)
    {
        return '<img src="'.$content->items[0]->volumeInfo->imageLinks->thumbnail.'">';
    }

    /**
     * @param $content
     * @return string
     */
    private function parseIsbn($content)
    {
        return $content->items[0]->volumeInfo->industryIdentifiers[0]->identifier;
    }

    /**
     * @param $content
     * @return float
     */
    private function parseRating($content)
    {
        return $content->items[0]->volumeInfo->averageRating;
    }

    private function checkContent($content)
    {
        if (!isset($content->items)) {
            return false;
        } else {
            return true;
        }
    }
}
