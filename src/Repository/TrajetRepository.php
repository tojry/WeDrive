<?php

namespace App\Repository;

use \Datetime;
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
    public function getTrajetsPassesUtilisateur($id) : array
    {
        $currentDate = new DateTime("now");
        return $qb = $this->createQueryBuilder('t')
                ->where('t.Covoitureur = :id')
                ->setParameter('id', $id)
                ->andWhere('t.dateHeureDepart < :date')
                ->setParameter('date', $currentDate)
                ->orderBy('t.dateHeureDepart', 'ASC')
                ->getQuery()
                ->getResult();
    }

    public function getTrajetsFutursUtilisateur($id) : array
    {
        $currentDate = new DateTime("now");
        return $qb = $this->createQueryBuilder('t')
                ->where('t.Covoitureur = :id')
                ->setParameter('id', $id)
                ->andWhere('t.dateHeureDepart >= :date')
                ->setParameter('date', $currentDate)
                ->orderBy('t.dateHeureDepart', 'ASC')
                ->getQuery()
                ->getResult();
    }

    public function rechercher(Recherche $r) : array
    {
        $depart  = $r->getLieuDepart();
        $arrivee = $r->getLieuArrivee();
        $date    = $r->getDateDepart();
        

        $qb = $this->createQueryBuilder('t');

        
        if($depart){
            $qb->andWhere('t.lieuDepart = :depart')
            ->setParameter('depart', $depart);
        }
        if($arrivee){
            $qb->andWhere('t.lieuArrive = :arrivee')
            ->setParameter('arrivee', $arrivee);
        }
        if($date){
            $from = new \DateTime($date->format("Y-m-d")." 00:00:00");
            $to   = new \DateTime($date->format("Y-m-d")." 23:59:59");
            $qb->andWhere('t.dateHeureDepart BETWEEN :from AND :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to);
        }
        $now = (new \DateTime('now'))->format("Y-m-d H:i:s");
        $qb->andWhere('t.dateHeureDepart > :now')
            ->setParameter('now', $now)
            ->andWhere('t.annulee = FALSE')
            ->orderBy('t.dateHeureDepart', 'ASC');
        
        $query  = $qb->getQuery();

        return $query->execute();
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
