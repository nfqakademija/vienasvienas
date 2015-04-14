<?php

namespace VienasVienas\Bundle\BooksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VienasVienas\Bundle\BooksBundle\Isbn;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $isbn = new Isbn();
        $isbn->setIsbn("9780099520276");
        $bookFinder = $this->get('books.finder')
            ->getBookByIsbn($isbn);


        return $this->render('BooksBundle:Default:index.html.twig');
    }
}
