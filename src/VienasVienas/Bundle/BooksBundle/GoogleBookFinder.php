<?php
/*
 * This file is part of the BooksBundle package.
 *
 * (c) Valdemar Karasevic <valdemar.karasevic@gmail.com>
 *
 */
namespace VienasVienas\Bundle\BooksBundle;

/**
 * Class GoogleBookFinder
 * @package VienasVienas\Bundle\BooksBundle
 */
class GoogleBookFinder implements BookFinderServiceInterface
{
    /**
     *
     */
    const API_URL = "https://www.googleapis.com/books/v1/volumes";

    /**
     * @param GoogleBookFinderParser $parser
     */
    public function __construct(GoogleBookFinderParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param Isbn $isbn
     * @return Entity\Books
     */
    public function getBookByIsbn(Isbn $isbn)
    {
        $content = $this->getContent($isbn);

        return $this->parser->parseBook($content);
    }

    /**
     * @param Isbn $isbn
     * @return object
     */
    public function getContent(Isbn $isbn)
    {
        $isbn = $isbn->getIsbn();
        $query = "?q=isbn:" . urlencode($isbn);
        $url = static::API_URL . $query;
        $session = curl_init($url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);

        return $response;
    }
}