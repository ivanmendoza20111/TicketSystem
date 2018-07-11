<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 7/10/2018
 * Time: 10:49 AM
 */

namespace AppBundle\Controller\Ticket;

use AppBundle\Entity\Ticket;
use AppBundle\Entity\User;
use AppBundle\Form\TicketType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    /**
     * @Route("/ticket", name="ticket")
     */
    public function indexAction(Request $request)
    {
        $tickets=$this->getDoctrine()->getManager()->getRepository(Ticket::class)->findBy(array('user'=>$this->getUser()));

        return $this->render('@App\Ticket\ticket.html.twig',array(
            'tickets'=>$tickets
        ));
    }

    /**
     * @Route("/ticket/new", name="ticket_new")
     */
    public function newAction(Request $request)
    {
        $ticket=new Ticket();
        $form=$this->createForm(TicketType::class,$ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ticket->setUser($this->getUser());
            $ticket->setDate(new \DateTime());
            $ticket->setStatus('Open');

            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();
            return $this->redirectToRoute('ticket');
        }

        $em=$this->getDoctrine()->getManager();
        $query=$em->createQuery(
            'SELECT u
             FROM AppBundle:User u
             WHERE u.status = :status
            '
        )->setParameter('status','Active');

        $employees=$query->getResult();

        return $this->render('@App\Ticket\new.html.twig',array(
            'form'=>$form->createView(),
            'employees'=>$employees
        ));
    }

    /**
     * @Route("/ticket/delete/{id}",options={"expose"=true}, name="remove_ticket")
     * @Method("GET")
     * @param Ticket $ticket
     */
    public function deleteEmployee(Ticket $ticket)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($ticket);
        $em->flush();
        return $this->redirectToRoute('ticket');
    }

    /**
     * @Route("/ticket/view/{id}", name="view_ticket", requirements={"id"="\d+"})
     * @Method("GET")
     * @param Ticket $ticket
     * @return Response
     */
    public function indexViewEmployee(Ticket $ticket)
    {
        return $this->render('@App\Ticket\view.html.twig',
            array(
                "ticket" => $ticket
            ));
    }

    //RestFul
    /**
     * @Route("/rest/ticket/{id}",options={"expose"=true}, name="delete_ticket")
     * @Method("DELETE")
     * @param Ticket $ticket
     * @return Response
     */
    public function deleteTicket(Ticket $ticket)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($ticket);
        $em->flush();
        return new Response("1");
    }
}