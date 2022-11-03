<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoisController extends AbstractController
{
    #[Route('/mois', name: 'app_mois')]
    public function index(): Response
    {
        return $this->render('mois/index.html.twig', [
            'controller_name' => 'MoisController',
        ]);
    }
}
