<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Form\PrestationType;

use App\Repository\MailingRepository;
use App\Entity\Mailing;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

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
    public function proposition(Request $request, MailerInterface $mailerInterface): Response
    {
        $prestation = new Prestation();
        $form = $this->createForm(PrestationType::class, $prestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prestation);
            $entityManager->flush();

            $mailingRepository = $this->getDoctrine()->getRepository(Mailing::class);
            $mailing = $mailingRepository->findOneBy(['ref' => 'VPrestaNew']);
            // dump($mailing);
    
            $email = (new Email())
            ->from('no-reply@upsidedownapp.com')
            ->to($prestation->getEmail())
            ->subject($mailing->getSubject())
            ->text($mailing->getContent())
            ->html($mailing->getHtml());
            $mailerInterface->send($email);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('prestation/new.html.twig', [
            'prestation' => $prestation,
            'form' => $form->createView(),
        ]);
    }

}

