<?php
/*
 * This file is part of the BooksBundle package.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */
namespace VienasVienas\Bundle\BooksBundle;


/**
 * Class Isbn
 * @package VienasVienas\Bundle\BooksBundle
 */
class Isbn
{
    /**
     * @var
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
     * @return string
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
