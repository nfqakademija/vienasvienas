<?php

namespace VienasVienas\Bundle\BooksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VienasVienas\Bundle\BooksBundle\Entity\Books;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BooksBundle:Default:bookadd.html.twig');
    }
}
