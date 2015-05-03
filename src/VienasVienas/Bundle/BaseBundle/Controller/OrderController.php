<?php

namespace VienasVienas\Bundle\BaseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Order controller.
 *
 * @Route("/order")
 */
class OrderController extends Controller
{

/**
 * Makes orders
 *
 * @Route("/{id}", name="make_order")
 * @Method("POST")
 */
    public function makeOrderAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'message' => 'You can access this only using Ajax!'
            ), 400);
        }
        $id = $request->request->get('id');

        $em = $this->getDoctrine()->getManager();
        $bookEntity = $em->getRepository('BooksBundle:Book')->find($id);
        $userEntity = $this->getUser();
        $this->get('make.order')->makeOrder($bookEntity, $userEntity);
        $quantity = $bookEntity->getQuantity();

        if (!$bookEntity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }

        return new JsonResponse(array(
            'quantity' => $quantity,
            'message' => 'Order confirmed',
        ), 200);
    }

    /**
     * Returns order
     *
     * @Route("/return/{id}", name="return_order")
     * @Method("POST")
     */
    public function returnOrderAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'message' => 'You can access this only using Ajax!'
            ), 400);
        }

        $id = $request->request->get('id');

        $em = $this->getDoctrine()->getManager();
        $bookEntity = $em->getRepository('BooksBundle:Book')->find($id);
        $userEntity = $this->getUser();
        $this->get('order.complete')->returnOrder($bookEntity, $userEntity);

        $quantity = $bookEntity->getQuantity();

        if (!$bookEntity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }


        return new JsonResponse(array(
            'quantity' => $quantity,
            'message' => 'Book returned successfully',
                    ), 200);
    }

    /**
     * Reserve order.
     *
     * @Route("/reserve/{id}", name="reserve_order")
     * @Method("POST")
     */
    public function reserveOrderAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'message' => 'You can access this only using Ajax!'
            ), 400);
        }

        $id = $request->request->get('id');

        $em = $this->getDoctrine()->getManager();
        $bookEntity = $em->getRepository('BooksBundle:Book')->find($id);
        $userEntity = $this->getUser();
        $this->get('reservation')->makeReservation($bookEntity, $userEntity);


        $quantity = $bookEntity->getQuantity();
        if (!$bookEntity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }

        return new JsonResponse(array(
            'quantity' => $quantity,
            'message' => 'Reservation confirmed',
        ), 200);
    }

    /**
     * Updates order.
     *
     * @Route("/update/{id}", name="update_order")
     * @Method("PUT")
     */
    public function updateOrderAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'message' => 'You can access this only using Ajax!'
            ), 400);
        }

        $id = $request->request->get('id');

        $em = $this->getDoctrine()->getManager();
        $bookEntity = $em->getRepository('BooksBundle:Book')->find($id);
        $userEntity = $this->getUser();
        $this->get('order.update')->updateOrder($bookEntity, $userEntity);

        $quantity = $bookEntity->getQuantity();

        if (!$bookEntity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }

        return new JsonResponse(array(
            'quantity' => $quantity,
            'message' => 'Order confirmed',
        ), 200);
    }
}
