<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 4/21/15
 * Time: 11:24 AM
 */

namespace VienasVienas\Bundle\BooksBundle\Services\BookFinderService;


use VienasVienas\Bundle\BooksBundle\BookFinderServiceInterface;

/**
 * Class GoodreadsFinder
 * @package VienasVienas\Bundle\BooksBundle\Services\BookFinderService
 */
class GoodreadsFinder implements BookFinderServiceInterface
{

    private $key_url;

    /**
     * @param $key_url
     */
    public function __construct($key_url)
    {
        $this->key_url = $key_url;
    }


    /**
     * @param Isbn $isbn
     * @return string
     */
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
        $format = "&format=json";

        $isbn = $isbn->getIsbn();
        $query = $url . $isbn ."&key=" . $this->key_url . $format;
        $session = curl_init($query);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);
        $response = json_decode($response);
        if (isset($response->{'reviews_widget'})) {
             $response = $response->{'reviews_widget'};
        }
        //Hiding unnecessary divs
        $style = 'gr_header, .gr_branding {display:none;}';
        $response = substr($response, 0, 7) . $style . substr($response, 7);

        return $response;
    }
}
