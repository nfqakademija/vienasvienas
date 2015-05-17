<?php

namespace VienasVienas\Bundle\BooksBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use VienasVienas\Bundle\BooksBundle\Entity\Book;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use VienasVienas\Bundle\BooksBundle\Form\BookType;
use VienasVienas\Bundle\BooksBundle\Services\BookFinderService\Isbn;

/**
 * Book controller.
 *
 * @Route("/book")
 */
class BooksController extends Controller
{
    /**
     * Lists all Book entities.
     *
     * @Route("/", name="book")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getRepository('BooksBundle:Book');
        //limiting queries to list on main page
        $entities = $em->findBy(array(), array( 'id' => 'DESC'), 400);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $request->get('page', 1)/*page number*/,
            10/*limit per page*/
        );
        $all = $em->findAll();
        $count = count($all);

        return array(
            'pagination' => $pagination,
            'count' => $count
        );
    }

    /**
     * Creates a new Book entity from scratch.
     *
     * @param Request $request
     *
     * @Route("/", name="book_create")
     * @Method("POST")
     * @Template("BooksBundle:Books:new.html.twig")
     *
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function createAction(Request $request)
    {
        $bookEntity = new Book();

        $form = $this->createBookForm($bookEntity);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($bookEntity);
                $em->flush();

                return $this->redirect(
                    $this->generateUrl('book_show', array('id' => $bookEntity->getId()))
                );
            }
        }

        return array(
            'entity' => $bookEntity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Book entity.
     *
     * @param Book $entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createBookForm(Book $entity)
    {
        $form = $this->createForm(new BookType(), $entity, array(
            'em' => $this->getDoctrine()->getManager(),
            'action' => $this->generateUrl('book_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Add'));

        return $form;
    }

    /**
     * Displays a form to create a new Book entity.
     *
     * @Route("/new", name="book_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Book();
        $form = $this->createBookForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Book entity by ISBN.
     *
     * @param Request $request
     *
     * @Route("/new_isbn", name="book_new_isbn")
     * @Template()
     *
     * @return Response
     */
    public function newIsbnAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('isbn', 'text')
            ->add('search', 'submit')
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $isbn = new Isbn();
                $isbnValue = $form['isbn']->getData();
                $isbnValue = preg_replace('/\D/', '', $isbnValue);
                $isbn->setIsbn($isbnValue);

                $bookFinder = $this->get('book.finder');
                $book = $bookFinder->getBookByIsbn($isbn);
                // If nothing found on google, try amazon API.
                if (null == $book->getIsbn()) {
                    $amazon = $this->get('amazon.books');
                    $book = $amazon->getBookByIsbn($isbn);
                }

                $form = $this->createBookForm($book);

                return array(
                    'form' => $form->createView(),
                    'book' => $book,
                );
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Book entity.
     *
     * @param int $id
     *
     * @Route("/{id}", name="book_show")
     * @Method("GET")
     * @Template()
     * @return Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $bookEntity = $em->getRepository('BooksBundle:Book')->find($id);

        $userEntity = $this->getUser();
        $userOrderStatus = $this->get('user.checker')->orderUserFinder($bookEntity, $userEntity);

        if (!$bookEntity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }
        $isBookReserved = $em->getRepository('BaseBundle:Order')->isBookReserved($bookEntity);

        $userEntity = $this->get('user.checker')->reservationUserFinder($bookEntity, $userEntity);

        if ($userEntity === true) {
            $userReservation = true;
        } else {
            $userReservation = false;
        }

        $deleteForm = $this->createDeleteForm($id);

        $isbn = new Isbn();
        $number = $bookEntity->getIsbn();
        $isbn->setIsbn($number);

        $goodreads = $this->get('goodreads.comments');
        $goodReadsComments = $goodreads->getComments($isbn);

        $amazon = $this->get('amazon.books');
        $amazonComments = $amazon->getComments($isbn);

        return array(
            'entity' => $bookEntity,
            'delete_form' => $deleteForm->createView(),
            'goodreads_comments' => $goodReadsComments,
            'amazon_comments' => $amazonComments,
            'user' => $userReservation,
            'order' => $userOrderStatus,
            'isBookReserved' => $isBookReserved,
        );
    }

    /**
     * Displays a form to edit an existing Book entity.
     *
     * @param int $id
     *
     * @Route("/{id}/edit", name="book_edit")
     * @Method("GET")
     * @Template()
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BooksBundle:Book')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Book entity.
     *
     * @param Book $entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Book $entity)
    {

        $form = $this->createForm(
            new BookType(), $entity, array(
            'em' => $this->getDoctrine()->getManager(),
            'action' => $this->generateUrl(
                'book_update', array(
                    'id' => $entity->getId()
                )
            ),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Book entity.
     *
     * @param Request $request
     * @param int     $id
     *
     * @Route("/{id}", name="book_update")
     * @Method("PUT")
     * @Template("BooksBundle:Books:edit.html.twig")
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BooksBundle:Book')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('book_edit', ['id' => $id]));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Book entity.
     *
     * @param Request $request
     * @param int     $id
     *
     * @Route("/{id}", name="book_delete")
     * @Method("DELETE")
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BooksBundle:Book')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Book entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('book'));
    }

    /**
     * Gets most popular books.
     *
     * @param Request $request
     *
     * @Route("/popular", name="most_popular")
     * @Method("GET")
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function mostPopularAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $mostPopular = $em->getRepository('BooksBundle:Book')->getMostPopularBooks();

        return $this->render(
            'BooksBundle:Books:mostPopular.html.twig', array(
                'mostPopular' => $mostPopular,
            )
        );
    }

    /**
     * Creates a form to delete a Book entity by id.
     *
     * @param int $id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'book_delete',
                    array(
                        'id' => $id
                    )
                )
            )
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
