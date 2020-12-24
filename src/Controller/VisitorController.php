<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitorController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('visitor/index.html.twig', [
            'controller_name' => 'Biographie',
        ]);
    }

    /**
     * @Route("/download", name="app_download")
     */
    public function download(): Response
    {
        return $this->render('visitor/index.html.twig', [
            'controller_name' => 'Téléchargement',
        ]);
    }

    /**
     * @Route("/proposition", name="app_proposition")
     */
    public function proposition(): Response
    {
        return $this->render('visitor/index.html.twig', [
            'controller_name' => 'Demande de prestation',
        ]);
    }
}

