<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 7/10/2018
 * Time: 10:49 AM
 */

namespace AppBundle\Controller\Ticket;

use AppBundle\Entity\Notes;
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
     * @Route("/ticket", name="ticket", options={"expose"=true})
     */
    public function indexAction(Request $request)
    {
        //$tickets=$this->getDoctrine()->getManager()->getRepository(Ticket::class)->findAll(array('user'=>$this->getUser()));
        $tickets=$this->getDoctrine()->getManager()->getRepository(Ticket::class)->findAll();

        return $this->render('@App\Ticket\ticket.html.twig',array(
            'tickets'=>$tickets
        ));
    }

    /**
     * @Route("/ticket/timeEntry/{id}", name="ticket_time_entry",options={"expose"=true})
     * @param Ticket $ticket
     */
    public function TimeEntryAction(Ticket $ticket)
    {
        return $this->render('@App\Ticket\TicketTime.html.twig',array(
            'ticket'=>$ticket
        ));
    }

    /**
     * @Route("/report", name="report")
     */
    public function reportAction(Request $request)
    {
        $report=array();


        return $this->render('@App\Ticket\Report\report.html.twig',array(
            'report'=>$report
        ));
    }

    /**
     * @Route("/ticket/timeEntry", name="time_entry_save")
     */
    public function newTimeAction(Request $request)
    {
        $note=new Notes();

        $note->setFecha(new \DateTime());
        $note->setNote($request->request->all()['note']);
        $note->setUser($this->getUser());

        $em=$this->getDoctrine()->getManager();
        $ticket=$em->getRepository(Ticket::class)->find($request->request->all()['id']);

        //Insertar Tickets a Notas
        $ticket->addTicketNote($note);

        //Verificar Estado enviado
        if($request->request->all()['status']=='Closed')
        {
            $ticket->setStatus($request->request->all()['status']);
            $ticket->setDateend(new \DateTime());
        }else{
            $ticket->setStatus($request->request->all()['status']);
            $ticket->setDateend(null);
        }

        $em->persist($note);
        $em->flush();

        return $this->redirectToRoute('ticket');
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

            //Obtener datos de empleados
            $employees=($request->request->all())['employees'];
            if(count($employees)>0) {
                foreach ($employees as $employee) {
                    $user = $em->getRepository(User::class)->find($employee);
                    $ticket->addEmployee($user);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();
            return $this->redirectToRoute('ticket');
        }

        //Buscando Usuarios Activos
        $em=$this->getDoctrine()->getManager();
        $employees=$em->getRepository(User::class)->findAllUserActive();

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
    public function removeTicket(Ticket $ticket)
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
    public function indexViewTicket(Ticket $ticket)
    {
        $employees=$ticket->getEmployees();
        $notes=$ticket->getTicketNote();

        return $this->render('@App\Ticket\view.html.twig',
            array(
                "ticket" => $ticket,
                'employees'=>$employees,
                'notes'=>$notes
            ));
    }

    /**
     * @Route("/ticket/edit/{id}", name="edit_ticket", requirements={"id"="\d+"})
     * @Method("GET")
     * @param Ticket $ticket
     * @return Response
     */
    public function indexEditTicket(Ticket $ticket)
    {
        $employees=$ticket->getEmployees();

        //Buscando Usuarios Activos
        $em=$this->getDoctrine()->getManager();
        $employeesActive=$em->getRepository(User::class)->findAllUserActive();

        return $this->render('@App\Ticket\edit.html.twig',
            array(
                "ticket" => $ticket,
                'employees'=>$employees,
                'employeesActive'=>$employeesActive
            ));
    }

    //RestFul
    /**
     * @Route("/rest/ticket/{id}",options={"expose"=true}, name="update_ticket")
     * @Method("PUT")
     * @param Request $request
     * @param Ticket $ticket
     * @return Response
     */
    public function updateTicket(Request $request,Ticket $ticket)
    {
        $data = $request->getContent();
        $data = (json_decode($data, true));

        $em=$this->getDoctrine()->getManager();

        $ticket->setSubject($data['subject']);
        $ticket->setDescription($data['description']);

        //Remover todos los empleados relacionados
        $employeesTickets=$ticket->getEmployees();
        if(count($employeesTickets)>0){
            foreach ($employeesTickets as $user) {
                $user = $em->getRepository(User::class)->find($user);
                $ticket->removeEmployee($user);
            }
        }

        //Obtener datos de empleados
        $employees=$data['empleoyees'];
        if(count($employees)>0) {
            foreach ($employees as $employee) {
                $user = $em->getRepository(User::class)->find($employee);
                $ticket->addEmployee($user);
            }
        }

        $em->flush();

        return new Response("1");
    }

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

    /**
     * @Route("/rest/ticket/delete/employee/{id}",options={"expose"=true}, name="delete_ticketEmployee")
     * @Method("DELETE")
     * @param Request $request
     * @param Ticket $ticket
     * @return Response
     */
    public function deleteTicketEmployees(Request $request,Ticket $ticket)
    {
        $data = $request->getContent();
        $data = (json_decode($data, true));

        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($data['idEmployee']);

        $ticket->removeEmployee($user);
        $em->flush();

        return new Response("1");
    }
}