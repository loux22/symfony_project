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

        $userlog = $this->getUser();
        if ($userlog == null) {
            return $this->redirectToRoute('login');
        }

        $manager = $this->getDoctrine()->getManager();
        $groupe = $manager->find(Groupe::class, $id);

        $messageForm = $this->sendMessage($groupe, $request);

        $repository = $this->getDoctrine()->getRepository(Message::class);
        $messages = $repository->findAllMessageOnGroupe($id);

        return $this->render('message/index.html.twig', [
            'messages' => $messages,
            'groupe' => $groupe,
            'messageForm' => $messageForm
        ]);
    }

    public function sendMessage($groupe, Request $request)
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


            if ($message->getContent() == null) {
                $this->addFlash('errors', 'Veuillez écrire un message');
            } else {
                $manager->persist($message);

                $manager->flush($message);
            }

            $this->redirectToRoute('message', array(
                'id' => $groupe->getId()
            ));
        }

        return $form->createView();
    }
}
