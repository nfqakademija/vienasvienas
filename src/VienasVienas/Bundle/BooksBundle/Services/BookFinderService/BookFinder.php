<?php

namespace VienasVienas\Bundle\BooksBundle\Services\BooksFinderServices;

use VienasVienas\Bundle\BooksBundle\BookFinderServiceInterface;

class BookFinder
{
    public function __construct(BookFinderServiceInterface $bookFinder)
    {
         $this->BookFinder = $bookFinder;
    }

    public function getBookByIsbn(Isbn $isbn)
    {
        return $this->BookFinder->getBookByIsbn($isbn);
    }
}
