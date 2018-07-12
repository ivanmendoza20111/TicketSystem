<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 7/12/2018
 * Time: 9:25 AM
 */

namespace AppBundle\Controller\Note;

use AppBundle\Entity\Notes;
use AppBundle\Entity\Ticket;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class NoteController extends Controller
{
    /**
     * @Route("/ticket/timeEntry/{id}", name="ticket_time_entry",options={"expose"=true})
     * @param Ticket $ticket
     */
    public function TimeEntryIndex(Ticket $ticket)
    {
        return $this->render('@App\Notes\TicketTime.html.twig',array(
            'ticket'=>$ticket
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

            //Calculo de Horas
            $hour=$ticket->getDate()->diff(new \DateTime());
            $ticket->setHours($hour->format('%H.%m'));
        }else{
            $ticket->setStatus($request->request->all()['status']);
            $ticket->setDateend(null);
        }

        $em->persist($note);
        $em->flush();

        return $this->redirectToRoute('ticket');
    }

    //RestFul

    /**
     * @Route("/rest/notes/delete/ticket/{id}",options={"expose"=true}, name="delete_note_ticket")
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
        $note=$em->getRepository(Notes::class)->find($data['noteId']);

        $ticket->removeTicketNote($note);
        $em->flush();

        return new Response("1");
    }
}