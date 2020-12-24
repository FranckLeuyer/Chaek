<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use DateInterval;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 * @Route("/calendar")
 */
class CalendarController extends AbstractController
{
    /**
     * @Route("/api/set/{dateRef}", name="api_set_event", methods={"GET"})
     */
    public function setEvent($dateRef, CalendarRepository $calendarRepository): Response
    {
        dump($dateRef);

        $calendar = new Calendar();
        $calendar->setDate(new DateTime($dateRef));
        $calendar->setBadge(false);
        $calendar->setUser($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($calendar);
        $entityManager->flush();

        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/delete/{dateRef}", name="api_delete_event", methods={"GET"})
     */
    public function deleteEvent($dateRef, CalendarRepository $calendarRepository): Response
    {
        dump($dateRef);
        $calendar = $calendarRepository->findOneBy([
            "date" => new DateTime($dateRef),
            "user" => $this->getUser()
        ]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($calendar);
        $entityManager->flush();


        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/setbadge/{dateRef}", name="api_update_event", methods={"GET"})
     */
    public function updateEvent($dateRef, CalendarRepository $calendarRepository): Response
    {
        dump($dateRef);
        $calendar = $calendarRepository->findOneBy([
            "date" => new DateTime($dateRef),
            "user" => $this->getUser()
        ]);
        $calendar->setBadge(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/get/{dateRef}", name="api_month_event", methods={"GET"})
     */
    public function monthEventsShow($dateRef, CalendarRepository $calendarRepository): Response
    {
        $dateRef .= '-01';
        $startDate = new DateTime($dateRef);
        $endDate = new DateTime($dateRef);

        $interval = new DateInterval('P5M');
        $endDate->add($interval);
        $endDate = $endDate->modify('last day of this month');

        $calendars = $calendarRepository->findByMonthEvents($startDate, $endDate,  $this->getUser());

        // Usefull code for debug
        // return $this->render('calendar/index.html.twig', [
        //     'calendars' => $calendars,
        // ]);

        // {"date":"2020-12-16", "badge":true,"title":"Example 1", "classname":"proposition"},
        // {"date":"2020-12-04","badge":false},
        // {"date":"2020-12-05","badge":false},
        // {"date":"2020-12-06","badge":false},
        // {"date":"2020-12-11","badge":false,"title":"Example 2","classname":"proposition"},

        $data = [];
        foreach ($calendars as $calendar){
            $event = [];
            $event['date'] = $calendar->getDate()->format('Y-m-d');
            if (!is_null($calendar->getBadge())) $event['badge'] = $calendar->getBadge();
            if (!is_null($calendar->getTitle())) $event['title'] = $calendar->getTitle();
            if (!is_null($calendar->getClassname())) $event['classname'] = $calendar->getClassname();
            $data[] = $event;
        }
        return $this->json($data);       

        
        // $normalizer = new ObjectNormalizer();
        // $encoder = new JsonEncoder();
        
        // $serializer = new Serializer([$normalizer], [$encoder]);
        // $output = $serializer->serialize($data, 'json', ['ignored_attributes' => ['user', 'transitions']]);

        // $response = new Response($output);
        // $response->headers->set('Content-Type', 'application/json');
        // return $response;

/*
        $data = [];
        foreach ($calendars as $calendar){
            $data[] = $calendar;
        }
        
        $normalizer = new ObjectNormalizer();
        $encoder = new JsonEncoder();
        
        $serializer = new Serializer([$normalizer], [$encoder]);
        $output = $serializer->serialize($data, 'json', ['ignored_attributes' => ['user', 'transitions']]);

        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
*/

        // $calendar = new Calendar();
        // $calendar->setDate(new \DateTime());
        // $data[] = $calendar;
        // return $this->json($data);       
    }

    /**
     * @Route("/", name="calendar_index", methods={"GET"})
     */
    public function index(CalendarRepository $calendarRepository): Response
    {
        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="calendar_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calendar->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($calendar);
            $entityManager->flush();

            return $this->redirectToRoute('calendar_index');
        }

        return $this->render('calendar/new.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calendar_show", methods={"GET"})
     */
    public function show(Calendar $calendar): Response
    {
        return $this->render('calendar/show.html.twig', [
            'calendar' => $calendar,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="calendar_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Calendar $calendar): Response
    {
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('calendar_index');
        }

        return $this->render('calendar/edit.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calendar_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Calendar $calendar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$calendar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($calendar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('calendar_index');
    }
}
