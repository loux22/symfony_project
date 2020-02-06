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

        $messageForm = $this->sendMessage($id, $request);

        return $this->render('message/index.html.twig', [
            'messages' => $messages,
            'groupe' => $groupe,
            'messageForm' => $messageForm
        ]);
    }

    public function sendMessage($id, Request $request)
    {
        $message = new Message();

        $form = $this->createForm(FormMessageType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();

            // $manager = $this->getDoctrine()->getManager();
            // $manager->persist($user);

            // $user->fileUpload();


            // $manager->flush($user);

            // $this->addFlash('success', 'La création de votre compte est une réussite ' . $user->getUsername());
            // return $this->redirectToRoute('home');
        }

        return $form->createView();
    }
}
