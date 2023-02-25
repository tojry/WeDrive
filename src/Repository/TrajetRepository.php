<?php

namespace App\Repository;

use App\Entity\Trajet;
use App\Entity\Recherche;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Trajet>
 *
 * @method Trajet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trajet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trajet[]    findAll()
 * @method Trajet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrajetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trajet::class);
    }

    public function save(Trajet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trajet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function ajouter(Trajet $t) : array
    {
        /*
        $this->dba_insert

        $qb = $this->createQueryBuilder('t')
            ->where('t.lieuDepart LIKE :depart')
            ->setParameter('depart', '%'.$r->getLieuDepart().'%')
            ->andWhere('t.lieuArrive LIKE :arrivee')
            ->setParameter('arrivee', '%'.$r->getLieuArrivee().'%')
            ->andWhere('t.dateHeureDepart BETWEEN :from AND :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->orderBy('t.dateHeureDepart', 'ASC')
        ;
        $query  = $qb->getQuery();

        return $query->execute();*/
        return [];
    }
}