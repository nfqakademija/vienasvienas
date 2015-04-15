<?php
/*
 * This file is part of the BooksBundle package.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */

namespace VienasVienas\Bundle\BooksBundle;

/**
 * Class BookFinder
 * @package VienasVienas\Bundle\BooksBundle
 */
class BookFinder
{
    /**
     * @param BookFinderServiceInterface $bookFinder
     */
    public function __construct(BookFinderServiceInterface $bookFinder)
    {
         $this->BookFinder = $bookFinder;
    }

    /**
     * @param Isbn $isbn
     * @return Entity\Books object
     */
    public function getBookByIsbn(Isbn $isbn)
    {
        return $this->BookFinder->getBookByIsbn($isbn);
    }
}
