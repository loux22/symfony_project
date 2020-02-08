<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Groupe;
use App\Entity\Message;
use App\Form\CreateGroupeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupeController extends AbstractController
{
    /**
     * @Route("/createGroupe", name="createGroupe")
     */
    public function createGroupe(Request $request)
    {
        $userLog = $this->getUser();
        if ($userLog == null) {
            return $this->redirectToRoute('login');
        }
        $groupe = new Groupe;


        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        $form = $this->createForm(CreateGroupeType::class, $groupe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();


            $groupe->setDate(new \DateTime());
            $groupe->setUsersP($userLog);
            $groupe->fileUpload();


            $userId = $request->request->all();

            if (isset($userId['userId'])) {
                $userId = $userId['userId'];
                foreach ($userId as $key => $value) {
                    $user = $manager->find(User::class, $value);
                    $groupe->addUser($user);
                }
                $groupe->addUser($userLog);
                $manager->persist($groupe);
                $manager->flush($groupe);
                $this->addFlash('success', 'La création de votre groupe est une réussite ');
                return $this->redirectToRoute('groupe', array(
                    'id' => $userLog->getId()
                ));
            } else {
                $this->addFlash('errors', 'tu dois inviter au moins 1 personne dans ton groupe');
            }
        }

        return $this->render('groupe/createGroupe.html.twig', [
            'createGroupeForm' => $form->createView(),
            'users' => $users,
        ]);
    }

    ///////////////////////////////////ajax pour la barre de recherche non fonctionnel///////////////////////////////////////
    // /**
    //  * @Route("/dzefzgrthy", name="search_user")
    //  */
    // public function search_user(Request $request)
    // {
    //     $request = $this->query->get('search-user-js');
    //     if ($request->isXmlHttpRequest()) {
    //         $username = $this->query->get('search-user-js');
    //         $repository = $this->getDoctrine()->getRepository(User::class);
    //         $array = $repository->likeUser($username);
    //         $response = new Response(json_encode($array));

    //         $response->headers->set('Content-Type', 'application/json');
    //         return $response;
    //     }
    // }

    /**
     * @Route("/groupe/{id}", name="groupe")
     */
    public function showAllGroupOfUser($id)
    {
        $userLog = $this->getUser();
        if ($userLog == null) {
            return $this->redirectToRoute('login');
        }
        $manager = $this->getDoctrine()->getManager();
        $user = $manager->find(User::class, $id);
        $groupes = $user->getGroupes();

        $visible = true;
        $messages = [];

        if (empty($groupes)) {
            $visible = false;
        }

        $repo = $this->getDoctrine()->getRepository(Message::class);

        $repository = $this->getDoctrine()->getRepository(Message::class);
        $allMessages = $repository->findAll();

        foreach ($groupes as $key => $groupe) {

            $statu = true;

            foreach ($allMessages as $allMessage) {

                if ($groupe != $allMessage->getGroupe() && $statu) {

                    $messages[$key][0] = "";
                    $messages[$key][1] = false;
                } else {

                    $messages[$key][0] = $repo->findLastMessageOnGroupe($groupe->getId());
                    $messages[$key][1] = true;
                    $statu = false;
                }
            }
        }


        return $this->render('groupe/index.html.twig', [
            "groupes" => $groupes,
            "messages" => $messages,
            "visible" => $visible
        ]);
    }
}
