<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * Finds the N upcoming reservations, ordered by dateDebut ASC.
     *
     * @return Reservation[]
     */
    public function findUpcoming(int $limit = 5): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.dateDebut >= :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('r.dateDebut', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Check if a time slot conflicts with an existing reservation for the same salle.
     * Optionally pass $excludeId to skip a specific reservation (for updates).
     *
     * @return Reservation[]
     */
    public function findConflicts(\App\Entity\Salle $salle, \DateTimeInterface $debut, \DateTimeInterface $fin, ?int $excludeId = null): array
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.salle = :salle')
            ->andWhere('r.dateFin > :debut AND r.dateDebut < :fin')
            ->setParameter('salle', $salle)
            ->setParameter('debut', $debut)
            ->setParameter('fin', $fin);

        if ($excludeId !== null) {
            $qb->andWhere('r.id != :excludeId')->setParameter('excludeId', $excludeId);
        }

        return $qb->getQuery()->getResult();
    }
}
