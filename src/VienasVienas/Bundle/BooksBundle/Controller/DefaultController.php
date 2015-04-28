<?php

namespace VienasVienas\Bundle\BooksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use VienasVienas\Bundle\BooksBundle\Services\BookFinderService\Isbn;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('BooksBundle:Default:index.html.twig');
    }
}
