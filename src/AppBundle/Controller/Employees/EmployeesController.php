<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 7/10/2018
 * Time: 11:12 AM
 */

namespace AppBundle\Controller\Employees;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EmployeesController extends Controller
{
    /**
     * @Route("/employees", name="employees")
     */
    public function indexAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $employees=$em->getRepository(User::class)->findAll();

        return $this->render('@App\Employees\employees.html.twig',array(
            'employees'=>$employees
        ));
    }

    /**
     * @Route("/employees/new", name="new_employees")
     */
    public function newAction(Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        $user=new User();
        $form= $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setDateCreated(new \DateTime());
            $user->setStatus('Active');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('employees');
        }

        return $this->render('@App\Employees\new.html.twig',array(
            'form'=>$form->createView()
        ));
    }
}