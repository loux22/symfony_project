<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignupType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $userlog = $this->getUser();
        if($userlog == null){
            return $this->redirectToRoute('signup');
        }
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
    public function signup(Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User;

        $userlog = $this->getUser();
        if($userlog != null){
            return $this->redirectToRoute('login');
        }

        $form = $this->createForm(SignupType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user); 

            $user -> fileUpload();
            

            $manager->flush($user); 

            $this->addFlash('success', 'La création de votre compte est une réussite ' . $user->getUsername());
            // return $this ->redirectToRoute('home');
        }

        return $this->render('user/signup.html.twig', [
            'signupForm' => $form -> createView(),
        ]);
    }
}
