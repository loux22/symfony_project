<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message/{id}", name="message")
     */
    public function index($id)
    {
        $repository = $this->getDoctrine()->getRepository(Message::class);

        $messages = $repository->findAllMessageOnGroupe($id);

        $manager = $this->getDoctrine()->getManager();
        $groupe = $manager->find(Groupe::class, $id);

        return $this->render('message/index.html.twig', [
            'messages' => $messages,
            'groupe' => $groupe
        ]);
    }
}
