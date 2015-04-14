<?php

namespace VienasVienas\Bundle\BooksBundle\Controller;

use Beta\B;
use Buzz\Message\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use VienasVienas\Bundle\BooksBundle\Entity\Books;
use VienasVienas\Bundle\BooksBundle\Form\BooksType;
use VienasVienas\Bundle\BooksBundle\Isbn;
use VienasVienas\Bundle\BooksBundle\GoogleBookFinderParser;

/**
 * Books controller.
 *
 * @Route("/books/list")
 */
class BooksController extends Controller
{

    /**
     * Lists all Books entities.
     *
     * @Route("/", name="books")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BooksBundle:Books')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Books entity.
     *
     * @Route("/", name="books_create")
     * @Method("POST")
     * @Template("BooksBundle:Books:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Books();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('books_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Books entity.
     *
     * @param Books $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Books $entity)
    {
        $form = $this->createForm(new BooksType(), $entity, array(
            'action' => $this->generateUrl('books_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Books entity.
     *
     * @Route("/new", name="books_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Books();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Books entity by ISBN.
     *
     * @Route("/new_isbn", name="books_new_isbn")
     * @Template()
     */
    public function newIsbnAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('isbn', 'text')
            ->add('search', 'submit')
            ->getForm();

        $isbn = new Isbn();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $isbnValue = $form["isbn"]->getData();
            $isbn->setIsbn($isbnValue);
            $bookFinder = $this->get('books.finder');
            $book =  $bookFinder->getBookByIsbn($isbn);
            $form = $this->createCreateForm($book);

            return array(
                'form' => $form->createView(),
                'book'=> $book,
            );
        }
        return array(
          'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Books entity.
     *
     * @Route("/{id}", name="books_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BooksBundle:Books')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Books entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Books entity.
     *
     * @Route("/{id}/edit", name="books_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BooksBundle:Books')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Books entity.');
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
     * Creates a form to edit a Books entity.
     *
     * @param Books $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Books $entity)
    {
        $form = $this->createForm(new BooksType(), $entity, array(
            'action' => $this->generateUrl('books_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Books entity.
     *
     * @Route("/{id}", name="books_update")
     * @Method("PUT")
     * @Template("BooksBundle:Books:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BooksBundle:Books')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Books entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('books_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Books entity.
     *
     * @Route("/{id}", name="books_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BooksBundle:Books')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Books entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('books'));
    }

    /**
     * Creates a form to delete a Books entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('books_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
