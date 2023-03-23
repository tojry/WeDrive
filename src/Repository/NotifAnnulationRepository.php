<?php

namespace App\Repository;

use App\Entity\NotifAnnulation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NotifAnnulation>
 *
 * @method NotifAnnulation|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotifAnnulation|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotifAnnulation[]    findAll()
 * @method NotifAnnulation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotifAnnulationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotifAnnulation::class);
    }

    public function save(NotifAnnulation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NotifAnnulation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return NotifAnnulation[] Returns an array of NotifAnnulation objects
     */
    public function findByUser($user): array
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.UtilisateurConcerne = :user')
            ->setParameter('user', $user)
            ->orderBy('n.dateHeureNotif', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?NotifAnnulation
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
