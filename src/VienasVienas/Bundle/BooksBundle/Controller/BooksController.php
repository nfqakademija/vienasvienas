<?php

namespace VienasVienas\Bundle\BooksBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VienasVienas\Bundle\BooksBundle\Entity\Book;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use VienasVienas\Bundle\BooksBundle\Form\BookType;
use VienasVienas\Bundle\BooksBundle\Services\BookFinderService\Isbn;

/**
 * Book controller.
 *
 * @Route("/book/list")
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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BooksBundle:Book')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Book entity from scratch.
     *
     * @Route("/", name="book_create")
     * @Method("POST")
     * @Template("BooksBundle:Books:new.html.twig")
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

                return $this->redirect($this->generateUrl('book_show', array('id' => $bookEntity->getId())));
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
     * @param Book $entity The entity
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
     * @Route("/new_isbn", name="book_new_isbn")
     * @Template()
     */
    public function newIsbnAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('isbn', 'text')
            ->add('search', 'submit')
            ->getForm();

        $isbn = new Isbn();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $isbnValue = $form['isbn']->getData();
                $isbn->setIsbn($isbnValue);

                $bookFinder = $this->get('book.finder');
                $book = $bookFinder->getBookByIsbn($isbn);

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
     * @Route("/{id}", name="book_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BooksBundle:Book')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $isbn = new Isbn();
        $number = $entity->getIsbn();
        $isbn->setIsbn($number);

        $goodreads = $this->get('goodreads.comments');
        $comments = $goodreads->getComments($isbn);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'comments' => $comments,
        );
    }

    /**
     * Displays a form to edit an existing Book entity.
     *
     * @Route("/{id}/edit", name="book_edit")
     * @Method("GET")
     * @Template()
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
     * @param Book $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Book $entity)
    {

        $form = $this->createForm(new BookType(), $entity, array(
            'em' => $this->getDoctrine()->getManager(),
            'action' => $this->generateUrl('book_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Book entity.
     *
     * @Route("/{id}", name="book_update")
     * @Method("PUT")
     * @Template("BooksBundle:Books:edit.html.twig")
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

            return $this->redirect($this->generateUrl('book_edit', array('id' => $id)));
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
     * @Route("/{id}", name="book_delete")
     * @Method("DELETE")
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
     * Creates a form to delete a Book entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('book_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
