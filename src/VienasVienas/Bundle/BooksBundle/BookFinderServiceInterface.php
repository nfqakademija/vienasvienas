<?php

namespace VienasVienas\Bundle\BooksBundle;


interface BookFinderServiceInterface
{
    public function getBookByIsbn(Isbn $isbn);
}
