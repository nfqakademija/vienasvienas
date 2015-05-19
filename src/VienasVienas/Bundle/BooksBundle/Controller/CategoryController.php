<?php

namespace VienasVienas\Bundle\BooksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use VienasVienas\Bundle\BooksBundle\Entity\Category;

/**
 * Class CategoryController.
 */
class CategoryController extends Controller
{
    /**
     * Renders menu from existing categories.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoriesAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $categories = $em->getRepository('BooksBundle:Category')->findAll();

        return $this->render(
            'BooksBundle:Category:categories.html.twig',
            array(
                'categories' => $categories,
            )
        );
    }

    /**
     * Gets all books by category name.
     *
     * @param Request  $request
     * @param int      $categoryId
     *
     * @return JsonResponse
     */
    public function categoriesAjaxAction(Request $request, $categoryId)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'message' => 'You can access this only using Ajax!'
            ), 400);
        }

        $bookFind = true;
        $em = $this->getDoctrine()->getEntityManager();
        $books = $em->getRepository('BooksBundle:Book')->getAllBooksByCategory($categoryId);

        if (!$books) {
            $bookFind = false;
        }



        return new JsonResponse(array(
            'books' => $this->renderView('BooksBundle:Books:listByCategory.html.twig',
            array(
                'entities' => $books,
            )),
            'booksFind' => $bookFind
        , 200));
    }
}