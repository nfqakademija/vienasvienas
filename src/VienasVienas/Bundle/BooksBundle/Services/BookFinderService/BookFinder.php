<?php
/*
 * This file is part of the BooksBundle package.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */
namespace VienasVienas\Bundle\BooksBundle\Services\BookFinderService;

use VienasVienas\Bundle\BooksBundle\BookFinderServiceInterface;

/**
 * Class BookFinder
 * @package VienasVienas\Bundle\BooksBundle\Services\BookFinderService
 */
class BookFinder
{
    /**
     * @var BookFinderServiceInterface
     */

    private $bookFinder;
    /**
     * @param BookFinderServiceInterface $bookFinder
     */
    public function __construct(BookFinderServiceInterface $bookFinder)
    {
         $this->bookFinder = $bookFinder;
    }

    /**
     * @param Isbn $isbn
     * @return object
     */
    public function getBookByIsbn(Isbn $isbn)
    {
        return $this->bookFinder->getBookByIsbn($isbn);
    }
}
