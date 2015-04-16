<?php

namespace VienasVienas\Bundle\BooksBundle\Services\BooksFinderServices;


class Isbn
{
    protected $isbn;

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
