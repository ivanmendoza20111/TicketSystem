<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 7/10/2018
 * Time: 10:49 AM
 */

namespace AppBundle\Controller\Ticket;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TicketController extends Controller
{
    /**
     * @Route("/ticket", name="ticket")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@App\Ticket\ticket.html.twig');
    }
}