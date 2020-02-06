<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Form\CreateGroupeType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class GroupeController extends AbstractController
{
    /**
     * @Route("/createGroupe", name="createGroupe")
     */
    public function createGroupe(Request $request)
    {
        $userLog = $this->getUser();
        if($userLog == null){
            return $this->redirectToRoute('login');
        }
        $u = $userLog->getId();
        $groupe = new Groupe;
        $form = $this->createForm(CreateGroupeType::class, $groupe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($groupe);

            $groupe->setDate(new \DateTime());
            $groupe->setUsersP($userLog);
            $groupe -> fileUpload();
            
            $manager->flush($groupe); 

            $this->addFlash('success', 'La création de votre groupe est une réussite ');
            // return $this ->redirectToRoute('home');
        }

        return $this->render('groupe/createGroupe.html.twig', [
            'createGroupeForm' => $form -> createView(),
            'u' => $u
            ]);
    }
}
