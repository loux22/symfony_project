<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GroupeController extends AbstractController
{
    /**
     * @Route("/createGroupe", name="createGroupe")
     */
    public function createGroupe()
    {
        return $this->render('groupe/createGroupe.html.twig', []);
    }
}
