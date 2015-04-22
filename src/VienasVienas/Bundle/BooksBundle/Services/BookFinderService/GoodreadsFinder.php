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

    /**
     * @param Isbn $isbn
     * @return mixed|string
     */
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
        if (isset($response->{'reviews_widget'})){
        $response = $response->{'reviews_widget'};
        }
        //Hiding unnecessary divs
        $style = "#gr_header, .gr_branding {display:none;}";
        $response = substr($response, 0, 7) . $style . substr($response, 7);
        return $response;

    }
}