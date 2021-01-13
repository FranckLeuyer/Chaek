<?php

namespace App\Controller;

use App\Entity\Mailing;
use App\Form\MailingType;
use App\Repository\MailingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mailing")
 */
class MailingController extends AbstractController
{
    /**
     * @Route("/", name="mailing_index", methods={"GET"})
     */
    public function index(MailingRepository $mailingRepository): Response
    {
        return $this->render('mailing/index.html.twig', [
            'mailings' => $mailingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mailing_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $mailing = new Mailing();
        $form = $this->createForm(MailingType::class, $mailing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mailing);
            $entityManager->flush();

            return $this->redirectToRoute('mailing_index');
        }

        return $this->render('mailing/new.html.twig', [
            'mailing' => $mailing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mailing_show", methods={"GET"})
     */
    public function show(Mailing $mailing): Response
    {
        return $this->render('mailing/show.html.twig', [
            'mailing' => $mailing,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mailing_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Mailing $mailing): Response
    {
        $form = $this->createForm(MailingType::class, $mailing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mailing_index');
        }

        return $this->render('mailing/edit.html.twig', [
            'mailing' => $mailing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mailing_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Mailing $mailing): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mailing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mailing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mailing_index');
    }
}
