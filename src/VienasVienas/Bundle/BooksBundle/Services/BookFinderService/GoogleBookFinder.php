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
 * Class GoogleBookFinder.
 *
 * @package VienasVienas\Bundle\BooksBundle\Services\BookFinderService
 */
class GoogleBookFinder implements BookFinderServiceInterface
{
    /**
     * Google APIs URL
     */
    const API_URL = 'https://www.googleapis.com/books/v1/volumes';

    /**
     * @var GoogleBookFinderParser
     */
    private $parser;

    /**
     * @var string Google API key.
     */
    private $googleKey;

    /**
     * @param GoogleBookFinderParser $parser
     * @param string                 $googleKey
     */
    public function __construct(GoogleBookFinderParser $parser, $googleKey)
    {
        $this->parser = $parser;
        $this->googleKey = $googleKey;
    }

    /**
     * @param Isbn $isbn
     *
     * @return \VienasVienas\Bundle\BooksBundle\Entity\Book
     */
    public function getBookByIsbn(Isbn $isbn)
    {
        $content = $this->getContent($isbn);

        return $this->parser->parseBook($content);
    }

    /**
     * @param Isbn $isbn
     *
     * @return object
     */
    public function getContent(Isbn $isbn)
    {
        $isbn = $isbn->getIsbn();
        $query = '?q=isbn:' . urlencode($isbn) . '&key=' . $this->googleKey;
        $url = static::API_URL . $query;
        $session = curl_init($url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);

        return $response;
    }
}
