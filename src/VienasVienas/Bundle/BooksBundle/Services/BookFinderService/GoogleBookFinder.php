<?php

namespace VienasVienas\Bundle\BooksBundle\Services\BooksFinderServices;

use VienasVienas\Bundle\BooksBundle\BookFinderServiceInterface;

class GoogleBookFinder implements BookFinderServiceInterface
{
    const API_URL = "https://www.googleapis.com/books/v1/volumes";

    public function __construct(GoogleBookFinderParser $parser)
    {
        $this->parser = $parser;
    }
    public function getBookByIsbn(Isbn $isbn)
    {
        $content = $this->getContent($isbn);

        return $this->parser->parseBook($content);
    }
    public function getContent(Isbn $isbn)
    {
        $isbn = $isbn->getIsbn();
        $query = "?q=isbn:".urlencode($isbn);
        $url = static::API_URL . $query;
        $session = curl_init($url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);

        return $response;
    }
}