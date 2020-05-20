<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/modifier", name="participant_modifier")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifierProfil(
       UserPasswordEncoderInterface $passwordEncoder, Request $request, EntityManagerInterface $em)
    {


        $participant = $this->getUser();
        $registerForm = $this->createForm(ParticipantType::class, $participant);


        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            $participant->setAdministrateur(false);
            $participant->setActif(true);


            $password = $passwordEncoder->encodePassword($participant, $participant->getPassword());
            $participant->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($participant);
            $em->flush();

            $this->addFlash("success", "Votre profile a été modifié avec succes !");
            return $this->redirectToRoute("home");

        }
        return $this->render('participant/modifier.html.twig', ["registerForm"=>$registerForm->createView()]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request,
                             EntityManagerInterface $em,
                             UserPasswordEncoderInterface $encoder)
    {
        $user = new Participant();

        $registerForm = $this->createForm(RegisterType::class, $user);
        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            //hasher le mot de passe
            $hashed = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hashed);

            $em->persist($user);
            $em->flush();
        }

        return $this->render("participant/register.html.twig",[
            'registerForm' => $registerForm->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {


        return $this->render('participant/login.html.twig', []);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){}
}