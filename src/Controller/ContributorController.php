<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class ContributorController extends AbstractController
{
    /**
     * @Route("/agenda", name="app_agenda")
     */
    public function agenda(): Response
    {
        return $this->render('contributor/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/discussion", name="app_dicussion")
     */
    public function discussion(): Response
    {
        return $this->render('visitor/index.html.twig', [
            'controller_name' => 'Discussion',
        ]);
    }

    /**
     * @Route("/documents", name="app_documents")
     */
    public function documents(): Response
    {
        return $this->render('visitor/index.html.twig', [
            'controller_name' => 'Documents',
        ]);
    }
}
