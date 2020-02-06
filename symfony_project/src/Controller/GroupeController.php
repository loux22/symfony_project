<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Form\CreateGroupeType;
use Symfony\Component\Routing\Annotation\Route;
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
}
