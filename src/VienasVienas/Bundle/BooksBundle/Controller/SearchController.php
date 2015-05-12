<?php

namespace VienasVienas\Bundle\BooksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class SearchController
 * @package VienasVienas\Bundle\BooksBundle\Controller
 */
class SearchController extends Controller
{
    /**
     * Search controller.
     * @Template
     */
    public function indexAction(Request $request)
    {
        $searchService = $this->get('search.books');
        $books = $searchService->getBooks($request);

        if (count($books) == 0) {
            return $this->render('BooksBundle:Search:notFound.html.twig');
        }
        if (count($books) == 1) {
            $bookID = $searchService->findBooksAPI($books);
            $bookID = (integer) $bookID[0]['id'];
            return $this->redirectToRoute('book_show', array('id' => $bookID));
        }

        return array(
            'entities' => $books
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autoCompleteAction(Request $request)
    {
        $searchService = $this->get('search.books');
        $books = $searchService->getBooks($request);

        $books = $searchService->findBooksAPI($books);

        return new JsonResponse($books, 200, array(
            'Cache-Control' => 'no-cache',
        ));
    }

}
