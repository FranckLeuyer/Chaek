<?php

namespace App\Controller;

use App\Entity\PrestationObject;
use App\Form\PrestationObjectType;
use App\Repository\PrestationObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/object")
 */
class PrestationObjectController extends AbstractController
{
    /**
     * @Route("/", name="prestation_object_index", methods={"GET"})
     */
    public function index(PrestationObjectRepository $prestationObjectRepository): Response
    {
        return $this->render('prestation_object/index.html.twig', [
            'prestation_objects' => $prestationObjectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="prestation_object_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $prestationObject = new PrestationObject();
        $form = $this->createForm(PrestationObjectType::class, $prestationObject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prestationObject);
            $entityManager->flush();

            return $this->redirectToRoute('prestation_object_index');
        }

        return $this->render('prestation_object/new.html.twig', [
            'prestation_object' => $prestationObject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prestation_object_show", methods={"GET"})
     */
    public function show(PrestationObject $prestationObject): Response
    {
        return $this->render('prestation_object/show.html.twig', [
            'prestation_object' => $prestationObject,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prestation_object_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PrestationObject $prestationObject): Response
    {
        $form = $this->createForm(PrestationObjectType::class, $prestationObject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prestation_object_index');
        }

        return $this->render('prestation_object/edit.html.twig', [
            'prestation_object' => $prestationObject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prestation_object_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PrestationObject $prestationObject): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prestationObject->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prestationObject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prestation_object_index');
    }
}
