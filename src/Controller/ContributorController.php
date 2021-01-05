<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use DateTime;
use DateInterval;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class ContributorController extends AbstractController
{
    /**
     * @Route("/agenda", name="app_agenda")
     */
    public function agenda(CalendarRepository $calendarRepository): Response
    {
        // following code should stay similare with CalendarController->monthEventsShow
        $startDate = new DateTime();
        $endDate = new DateTime();

        $interval = new DateInterval('P5M');
        $endDate->add($interval);
        $endDate = $endDate->modify('last day of this month');

        $calendars = $calendarRepository->findByMonthEvents($startDate, $endDate,  $this->getUser());

        $data = [];
        foreach ($calendars as $calendar){
            $event = [];
            $event['date'] = $calendar->getDate()->format('Y-m-d');
            if (!is_null($calendar->getBadge())) $event['badge'] = $calendar->getBadge();
            if (!is_null($calendar->getTitle())) $event['title'] = $calendar->getTitle();
            if (!is_null($calendar->getClassname())) $event['classname'] = $calendar->getClassname();
            $data[] = $event;
        }
        // dump($this->json($data));

        return $this->render('contributor/index.html.twig', [
            'events' => $this->json($data),
        ]);


        // $normalizer = new ObjectNormalizer();
        // $serializer = new Serializer([$normalizer]);        
        // $dataOut = $serializer->normalize($data);
        // dump($data);

        // return $this->render('contributor/index.html.twig', [
        //     'events' => $dataOut,
        // ]);
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
