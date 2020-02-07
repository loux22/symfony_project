<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Entity\Message;
use App\Form\FormMessageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message/{id}", name="message")
     */
    public function index($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Message::class);
        $messages = $repository->findAllMessageOnGroupe($id);

        $manager = $this->getDoctrine()->getManager();
        $groupe = $manager->find(Groupe::class, $id);

        $messageForm = $this->sendMessage($id, $groupe, $request);

        return $this->render('message/index.html.twig', [
            'messages' => $messages,
            'groupe' => $groupe,
            'messageForm' => $messageForm
        ]);
    }

    public function sendMessage($id, $groupe, Request $request)
    {
        $message = new Message();

        $form = $this->createForm(FormMessageType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();

            $message->setUser($user);
            $message->setGroupe($groupe);
            $message->setDate(new \DateTime('now'));
            $message->setState(0);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($message);

            $manager->flush($message);

            return $this->redirectToRoute('message', array(
                'id' => $id
            ));
        }

        return $form->createView();
    }
}
