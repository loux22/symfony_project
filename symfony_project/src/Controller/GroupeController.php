<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Form\CreateGroupeType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class GroupeController extends AbstractController
{
    /**
     * @Route("/groups", name="seeGroups")
     */
    public function seeGroups()
    {
        return $this->render('groupe/groups.html.twig', []);
    }
    
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
//     public function lastMessageOnGroupe($id){

//     $message = $this->getDoctrine()
//     ->getRepository('AscamessagesBundle:message')
//     ->findAll();
     
//     if (!$message) {
//         throw $this->createNotFoundException(
//                 'Aucun message trouvé pour cet id : '.$id
//         );
//     }
//     return $this->render("AscamessagesBundle:views:groupe.html.twig", array(
//             'groupes' => $groupes,
//     ));
// }
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
        
        $repo = $this->getDoctrine()->getRepository(Message::class);

        // foreach ($user as $users) {
        //     $lastMessage = $message
        //     ->getRepository('UserBundle:message')
        //     ->myFindDerniersByuser($user);
             
        //     foreach ($message as $a){
        //         array_push($message, $m);
        //     }
        // }    
            foreach ($groupes as $groupe) {
                $messages[] = $repo->findLastMessageOnGroupe($groupe -> getId());
            }


        return $this-> render('groupe/index.html.twig', [
            "groupes" => $groupes,
            "messages" => $messages
        ]);

        // return new Response(count($groupe) . "Groupe dans le repertoire");
}

}