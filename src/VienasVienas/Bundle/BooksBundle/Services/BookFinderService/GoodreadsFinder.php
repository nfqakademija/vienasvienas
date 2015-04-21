<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 4/21/15
 * Time: 11:24 AM
 */

namespace VienasVienas\Bundle\BooksBundle\Services\BookFinderService;


use VienasVienas\Bundle\BooksBundle\BookFinderServiceInterface;

class GoodreadsFinder implements BookFinderServiceInterface
{


    public function getBookByIsbn(Isbn $isbn)
    {
        $content = $this->getComments($isbn);
        return $content;
    }

    public function getComments(Isbn $isbn)
    {
        $url = 'https://www.goodreads.com/book/isbn?isbn=';
        $key_url = '&key=v0RTVOCyM4jroqWH4P5vQ&format=json';

        $isbn = $isbn->getIsbn();
        $query = $url . $isbn . $key_url;
        $session = curl_init($query);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);
        $response = json_decode($response);
        $response = $response->{'reviews_widget'};

        return $response;

    }
}