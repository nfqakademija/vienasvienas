<?php

namespace VienasVienas\Bundle\BooksBundle;

use VienasVienas\Bundle\BooksBundle\Services\BooksFinderServices\Isbn;


interface BookFinderServiceInterface
{
    public function getBookByIsbn(Isbn $isbn);
}
