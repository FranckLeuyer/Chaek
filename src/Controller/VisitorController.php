<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Form\PrestationType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/proposition", name="app_proposition", methods={"GET","POST"})
     */
    public function proposition(Request $request): Response
    {
        $prestation = new Prestation();
        $form = $this->createForm(PrestationType::class, $prestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prestation);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('prestation/new.html.twig', [
            'prestation' => $prestation,
            'form' => $form->createView(),
        ]);
    }

}

