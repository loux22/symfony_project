<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignupType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('user/login.html.twig', ['error' => $error]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }

     /**
     * @Route("/signup", name="signup")
     */
    public function signup(Request $request)
    {
        $user = new User;
        $user = $this->getUser();
        if($user != null){
            return $this->redirectToRoute('login');
        }
        $form = $this->createForm(SignupType::class, $user);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user); //ENREGISTRE L'OBJET DANS LE SYSTEME 

            // $post-> fileUpload();

            $manager->flush($user); //EXECUTE LA OU LES REQUETES ENREGISTREE

            $this->addFlash('success', 'La création de votre compte est une réussite ' . $user->getUsername());
            // return $this ->redirectToRoute('admin_post');
        }

        return $this->render('user/signup.html.twig', ['signupForm' => $form -> createView(),'user' => $user]);
    }
}
