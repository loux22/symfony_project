<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class GroupeController extends AbstractController
{
    /**
     * @Route("/groupe", name="groupe")
     */
    public function index()
    {
        return $this->render('groupe/index.html.twig', [
            'controller_name' => 'GroupeController',
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
        $message = $manager->find(message::class, $id);


        return $this->render('groupe/index.html.twig', [
            "groupes" => $groupes,
            "message" => $message
        ]);

        // return new Response(count($groupe) . "Groupe dans le repertoire");
    }
}
