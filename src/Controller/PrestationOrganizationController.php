<?php

namespace App\Controller;

use App\Entity\PrestationOrganization;
use App\Form\PrestationOrganizationType;
use App\Repository\PrestationOrganizationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/organization")
 */
class PrestationOrganizationController extends AbstractController
{
    /**
     * @Route("/", name="prestation_organization_index", methods={"GET"})
     */
    public function index(PrestationOrganizationRepository $prestationOrganizationRepository): Response
    {
        return $this->render('prestation_organization/index.html.twig', [
            'prestation_organizations' => $prestationOrganizationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="prestation_organization_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $prestationOrganization = new PrestationOrganization();
        $form = $this->createForm(PrestationOrganizationType::class, $prestationOrganization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prestationOrganization);
            $entityManager->flush();

            return $this->redirectToRoute('prestation_organization_index');
        }

        return $this->render('prestation_organization/new.html.twig', [
            'prestation_organization' => $prestationOrganization,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prestation_organization_show", methods={"GET"})
     */
    public function show(PrestationOrganization $prestationOrganization): Response
    {
        return $this->render('prestation_organization/show.html.twig', [
            'prestation_organization' => $prestationOrganization,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prestation_organization_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PrestationOrganization $prestationOrganization): Response
    {
        $form = $this->createForm(PrestationOrganizationType::class, $prestationOrganization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prestation_organization_index');
        }

        return $this->render('prestation_organization/edit.html.twig', [
            'prestation_organization' => $prestationOrganization,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prestation_organization_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PrestationOrganization $prestationOrganization): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prestationOrganization->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prestationOrganization);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prestation_organization_index');
    }
}
