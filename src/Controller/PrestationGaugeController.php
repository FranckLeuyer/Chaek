<?php

namespace App\Controller;

use App\Entity\PrestationGauge;
use App\Form\PrestationGaugeType;
use App\Repository\PrestationGaugeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gauge")
 */
class PrestationGaugeController extends AbstractController
{
    /**
     * @Route("/", name="prestation_gauge_index", methods={"GET"})
     */
    public function index(PrestationGaugeRepository $prestationGaugeRepository): Response
    {
        return $this->render('prestation_gauge/index.html.twig', [
            'prestation_gauges' => $prestationGaugeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="prestation_gauge_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $prestationGauge = new PrestationGauge();
        $form = $this->createForm(PrestationGaugeType::class, $prestationGauge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prestationGauge);
            $entityManager->flush();

            return $this->redirectToRoute('prestation_gauge_index');
        }

        return $this->render('prestation_gauge/new.html.twig', [
            'prestation_gauge' => $prestationGauge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prestation_gauge_show", methods={"GET"})
     */
    public function show(PrestationGauge $prestationGauge): Response
    {
        return $this->render('prestation_gauge/show.html.twig', [
            'prestation_gauge' => $prestationGauge,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prestation_gauge_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PrestationGauge $prestationGauge): Response
    {
        $form = $this->createForm(PrestationGaugeType::class, $prestationGauge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prestation_gauge_index');
        }

        return $this->render('prestation_gauge/edit.html.twig', [
            'prestation_gauge' => $prestationGauge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prestation_gauge_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PrestationGauge $prestationGauge): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prestationGauge->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prestationGauge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prestation_gauge_index');
    }
}
