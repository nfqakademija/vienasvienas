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
     * @param Category $categoryName
     *
     * @return JsonResponse
     */
    public function categoriesAjaxAction(Request $request, $categoryName)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'message' => 'You can access this only using Ajax!'
            ), 400);
        }

        $category = urldecode($categoryName);
        $em = $this->getDoctrine()->getEntityManager();
        $categoryId = $em->getRepository('BooksBundle:Category')->getCategoryId($category);
        $books = $em->getRepository('BooksBundle:Book')->getAllBooksByCategory($categoryId);



        return new JsonResponse(array('books' => $this->renderView('BooksBundle:Books:listByCategory.html.twig',
            array(
                'entities' => $books,
            ))), 200);
    }
}