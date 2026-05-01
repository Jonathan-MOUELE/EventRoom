<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('crud_table.html.twig', [
            'mode'               => 'index',
            'entity_label'       => 'Réservation',
            'entity_name_plural' => 'Réservations',
            'route_prefix'       => 'app_reservation_',
            'headers'            => ['ID', 'Salle', 'Responsable', 'Début', 'Fin'],
            'fields'             => ['id', 'salle', 'utilisateur', 'dateDebut', 'dateFin'],
            'items'              => $em->getRepository(Reservation::class)->findAll(),
        ]);
    }

    #[Route('/reservation/create', name: 'app_reservation_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em, ReservationRepository $repo): Response
    {
        $reservation = new Reservation();
        $form        = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérification des conflits de créneaux
            $conflits = $repo->findConflicts(
                $reservation->getSalle(),
                $reservation->getDateDebut(),
                $reservation->getDateFin()
            );

            if (count($conflits) > 0) {
                $this->addFlash('danger', 'Cette salle est déjà réservée sur ce créneau horaire. Veuillez choisir un autre créneau.');
            } else {
                $em->persist($reservation);
                $em->flush();
                $this->addFlash('success', 'La réservation a été créée avec succès !');
                return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('crud_table.html.twig', [
            'mode'               => 'new',
            'entity_label'       => 'Réservation',
            'entity_name_plural' => 'Réservations',
            'route_prefix'       => 'app_reservation_',
            'form'               => $form,
        ]);
    }

    #[Route('/reservation/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('crud_table.html.twig', [
            'mode'               => 'show',
            'entity_label'       => 'Réservation',
            'entity_name_plural' => 'Réservations',
            'route_prefix'       => 'app_reservation_',
            'item'               => $reservation,
            'show_fields'        => [
                'id'          => 'Identifiant',
                'salle'       => 'Salle réservée',
                'utilisateur' => 'Responsable',
                'dateDebut'   => 'Date et heure de début',
                'dateFin'     => 'Date et heure de fin',
            ],
        ]);
    }

    #[Route('/reservation/{id}/update', name: 'app_reservation_update', methods: ['GET', 'POST'])]
    public function update(Request $request, Reservation $reservation, EntityManagerInterface $em, ReservationRepository $repo): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérification des conflits (en excluant la réservation actuelle)
            $conflits = $repo->findConflicts(
                $reservation->getSalle(),
                $reservation->getDateDebut(),
                $reservation->getDateFin(),
                $reservation->getId()
            );

            if (count($conflits) > 0) {
                $this->addFlash('danger', 'Cette salle est déjà réservée sur ce créneau horaire. Veuillez choisir un autre créneau.');
            } else {
                $em->flush();
                $this->addFlash('success', 'La réservation a été modifiée avec succès !');
                return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('crud_table.html.twig', [
            'mode'               => 'edit',
            'entity_label'       => 'Réservation',
            'entity_name_plural' => 'Réservations',
            'route_prefix'       => 'app_reservation_',
            'item'               => $reservation,
            'form'               => $form,
        ]);
    }

    #[Route('/reservation/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $em->remove($reservation);
            $em->flush();
            $this->addFlash('success', 'La réservation a été supprimée.');
        }
        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
