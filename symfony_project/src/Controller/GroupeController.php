<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Form\CreateGroupeType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupeController extends AbstractController
{
    /**
     * @Route("/createGroupe", name="createGroupe")
     */
    public function createGroupe()
    {
        $groupe = new Groupe;
        $form = $this->createForm(CreateGroupeType::class, $groupe);

        return $this->render('groupe/createGroupe.html.twig', [
            'createGroupeForm' => $form -> createView()
            ]);
    }

    // /**
    //  * @Route("/groupe/(id)", name="groupe")
    //  */
    // public function showgroup($id){
    //     $groupe = $this -> getDoctrine()
    //         -> getRepository('GroupeController.php')
    //         -> find($id);

    //     if(!$groupe){
    //         throw $this -> createNotFoundException('Aucun groupe ne correspond à votre recherche ');
    //     }
    // }


    /**
     * @Route("/groupe/{id}", name="groupe")
     */
    public function showAllGroupOfUser($id){
        $manager = $this -> getDoctrine() -> getManager();
        $user = $manager -> find(User::class, $id);
        $groupes = $user->getGroupes();
        
        $manager = $this->getDoctrine()->getManager();
        $message = $manager->find(Message::class, $id);


        return $this->render('groupe/index.html.twig', [
            "groupes" => $groupes,
            "message" => $message
        ]);

        // return new Response(count($groupe) . "Groupe dans le repertoire");
    }
}
