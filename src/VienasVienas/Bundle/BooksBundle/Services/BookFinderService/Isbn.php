<?php

/*
 * This file is part of the BooksBundle package.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */

namespace VienasVienas\Bundle\BooksBundle\Services\BookFinderService;

/**
 * Class Isbn constructs ISBN object.
 *
 * @package VienasVienas\Bundle\BooksBundle\Services\BookFinderService
 */
class Isbn
{
    /**
     * @var string ISBN
     */
    protected $isbn;

    /**
     * @param $isbn
     */
    public function __constructor($isbn)
    {
        $this->isbn = $isbn;
    }
    /**
     * @return string $isbn
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }


}
