<?php
/**
 * Created by PhpStorm.
 * User: ivanm
 * Date: 7/10/2018
 * Time: 11:12 AM
 */

namespace AppBundle\Controller\Employee;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    /**
     * @Route("/employees", name="employees", options={"expose"=true})
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
     * @Route("/employee/edit/{id}", name="edit_employee", requirements={"id"="\d+"})
     * @Method("GET")
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function indexEditEmployee(Request $request, User $user,UserPasswordEncoderInterface $passwordEncoder)
    {
        return $this->render('@App\Employees\edit.html.twig',
            array(
                "employee" => $user,
            ));
    }

    /**
     * @Route("/employe/view/{id}", name="view_employee", requirements={"id"="\d+"})
     * @Method("GET")
     * @param User $user
     * @return Response
     */
    public function indexViewEmployee(User $user)
    {
        return $this->render('@App\Employees\view.html.twig',
            array(
                "employee" => $user
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
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setDateCreated(new \DateTime());
            $user->setStatus('Active');

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('employees');
        }

        return $this->render('@App\Employees\new.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    //Restful
    /**
     * @Route("/rest/employee/{id}",options={"expose"=true}, name="update_employee")
     * @Method("PUT")
     * @param Request $request
     * @param User $usuario
     * @return Response
     */
    public function updateEmployee(Request $request,User $user)
    {
        $data = $request->getContent();
        $data = (json_decode($data, true));

        $user->setName($data['name']);
        $user->setLastname($data['lastname']);
        $user->setUsername($data['username']);
        $user->setStatus($data['status']);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new Response("1");
    }

    /**
     * @Route("/rest/employee/{id}",options={"expose"=true}, name="delete_employee")
     * @Method("DELETE")
     * @param User $user
     * @return Response
     */
    public function deleteEmployee(User $user)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return new Response("1");
    }
}