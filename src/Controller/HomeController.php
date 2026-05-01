<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use App\Repository\SalleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SalleRepository $salleRepository, ReservationRepository $reservationRepository): Response
    {
        return $this->render('home.html.twig', [
            'nb_salles'       => $salleRepository->count([]),
            'nb_reservations' => $reservationRepository->count([]),
            'prochaines'      => $reservationRepository->findUpcoming(5),
        ]);
    }
}
