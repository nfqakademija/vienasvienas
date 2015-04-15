<?php
/*
 * This file is part of the BooksBundle package.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */
namespace VienasVienas\Bundle\BooksBundle;


/**
 * Interface BookFinderServiceInterface
 * @package VienasVienas\Bundle\BooksBundle
 */
interface BookFinderServiceInterface
{
    /**
     * @param Isbn $isbn
     * @return object
     */
    public function getBookByIsbn(Isbn $isbn);
}
