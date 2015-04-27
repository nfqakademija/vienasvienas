<?php

namespace VienasVienas\Bundle\BooksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use VienasVienas\Bundle\BooksBundle\Services\BookFinderService\Isbn;

class DefaultController extends Controller
{

    public function indexAction()
    {
        //$isbn = "9785415023097";
        $isbn = new Isbn();
        $isbn->setIsbn('9785415023097');
        $amazon = $this->get('amazon.books');
        $response = $amazon->getBookByIsbn($isbn);

        return new Response($response);
    }
}
