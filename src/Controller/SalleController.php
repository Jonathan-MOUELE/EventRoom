<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\SalleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class SalleController extends AbstractController
{
    #[Route('/salle', name: 'app_salle_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('crud_table.html.twig', [
            'mode'               => 'index',
            'entity_label'       => 'Salle',
            'entity_name_plural' => 'Salles',
            'route_prefix'       => 'app_salle_',
            'headers'            => ['Image', 'ID', 'Nom', 'Capacité', 'Prix'],
            'fields'             => ['image', 'id', 'nom', 'capacite', 'prix'],
            'items'              => $em->getRepository(Salle::class)->findAll(),
        ]);
    }

    #[Route('/salle/create', name: 'app_salle_create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $salle = new Salle();
        $form  = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($salle);
            $em->flush();
            $this->addFlash('success', "La salle « {$salle->getNom()} » a été créée avec succès !");
            return $this->redirectToRoute('app_salle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud_table.html.twig', [
            'mode'               => 'new',
            'entity_label'       => 'Salle',
            'entity_name_plural' => 'Salles',
            'route_prefix'       => 'app_salle_',
            'form'               => $form,
        ]);
    }

    #[Route('/salle/{id}', name: 'app_salle_show', methods: ['GET'])]
    public function show(Salle $salle): Response
    {
        return $this->render('crud_table.html.twig', [
            'mode'               => 'show',
            'entity_label'       => 'Salle',
            'entity_name_plural' => 'Salles',
            'route_prefix'       => 'app_salle_',
            'item'               => $salle,
            'show_fields'        => [
                'id'          => 'Identifiant',
                'nom'         => 'Nom de la salle',
                'capacite'    => 'Capacité maximale',
                'prix'        => 'Prix par heure (€)',
                'description' => 'Description',
                'image'       => 'Illustration',
            ],
        ]);
    }

    #[Route('/salle/{id}/update', name: 'app_salle_update', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function update(Request $request, Salle $salle, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', "La salle « {$salle->getNom()} » a été mise à jour avec succès !");
            return $this->redirectToRoute('app_salle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud_table.html.twig', [
            'mode'               => 'edit',
            'entity_label'       => 'Salle',
            'entity_name_plural' => 'Salles',
            'route_prefix'       => 'app_salle_',
            'item'               => $salle,
            'form'               => $form,
        ]);
    }

    #[Route('/salle/{id}', name: 'app_salle_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Salle $salle, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $salle->getId(), $request->request->get('_token'))) {
            $nom = $salle->getNom();
            $em->remove($salle);
            $em->flush();
            $this->addFlash('success', "La salle « {$nom} » a été supprimée.");
        }
        return $this->redirectToRoute('app_salle_index', [], Response::HTTP_SEE_OTHER);
    }
}
