<?php

namespace VienasVienas\Bundle\BaseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Order controller.
 *
 * @Route("/order")
 */
class OrderController extends Controller
{
    /**
     * Makes orders.
     *
     * @param Request $request
     *
     * @Route("/{id}", name="make_order")
     * @Method("POST")
     *
     *
     * @return JsonResponse
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

        $isBookReserved = $em->getRepository('BaseBundle:Order')->isBookReserved($bookEntity);

        if ($isBookReserved == true) {
            $this->get('token.setter')->setTokenToUser($bookEntity);
        }

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
     * @param Request $request
     *
     * @Route("/reserve/{id}", name="reserve_order")
     * @Method("POST")
     *
     *
     * @return JsonResponse
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

    /**
     * Updates order by email.
     *
     * @Route("/update/{id}/{token}", name="update_order_by_email")
     * @Method("PUT")
     */
    public function updateOrderByEmailAction(Request $request, $id, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $orderEntity = $em->getRepository('BaseBundle:Order')->findOneByToken($token);
        $bookEntity = $em->getRepository('BooksBundle:Book')->findOneById($id);

        if (!$bookEntity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }

        if ($orderEntity == true) {
            $requestTime = $request->server->get('REQUEST_TIME');

            $validToken = $this->get('token.checker')->checkToken($requestTime, $orderEntity);

            if ($validToken) {
                $userEntity = $this->getUser();
                $this->get('order.update')->updateOrder($bookEntity, $userEntity);
                $orderEntity->setToken(null);

                $em->flush();
            }
        } else {
            throw $this->createNotFoundException('Token is not valid');
        }

        return $this->render(':Order:orderConfirmed.html.twig');
    }

    /**
     * Deletes order by email.
     *
     * @Route("/delete/{id}/{token}", name="delete_order_by_email")
     * @Method("PUT")
     */
    public function deleteOrderByEmailAction(Request $request, $id, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $orderEntity = $em->getRepository('BaseBundle:Order')->findOneByToken($token);
        $bookEntity = $em->getRepository('BooksBundle:Book')->findOneById($id);

        if (!$bookEntity) {
            throw $this->createNotFoundException('Unable to find Book entity.');
        }

        if ($orderEntity == true) {
            $requestTime = $request->server->get('REQUEST_TIME');

            $validToken = $this->get('token.checker')->checkToken($requestTime, $orderEntity);

            if ($validToken) {
                $orderEntity->setToken(null);
                $orderEntity->setStatus('done');
                $orderEntity->setReservationDate(null);

                $em->flush();

                $isBookReserved = $em->getRepository('BaseBundle:Order')->isBookReserved($bookEntity);

                if ($isBookReserved == true) {
                    $this->get('token.setter')->setTokenToUser($bookEntity);
                }
            }
        } else {
            throw $this->createNotFoundException('Token is not valid');
        }

        return $this->render(
            ':Order:orderCancel.html.twig');
    }
}
