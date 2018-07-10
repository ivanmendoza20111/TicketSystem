<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        //Verificar si hay usuarios
        $em=$this->getDoctrine()->getManager();
        $employes=$em->getRepository(User::class)->findAll();
        if(count($employes)==0)
        {
            $user=new User();
            $user->setName('Ivan');
            $user->setLastname('Mendoza');
            $user->setDateCreated(new \DateTime());
            $user->setStatus('ACTIVO');
            $user->setUsername('i.mendoza');

            $plainPassword = '1234';
            $password = $passwordEncoder->encodePassword($user, $plainPassword);

            $user->setPassword($password);

            $em->persist($user);
            $em->flush();
        }

        return $this->redirectToRoute('login');
    }
}
