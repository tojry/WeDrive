<?php

namespace App\Repository;

use App\Entity\NotifTrajetPrive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NotifTrajetPrive>
 *
 * @method NotifTrajetPrive|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotifTrajetPrive|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotifTrajetPrive[]    findAll()
 * @method NotifTrajetPrive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotifTrajetPriveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotifTrajetPrive::class);
    }

    public function save(NotifTrajetPrive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NotifTrajetPrive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return NotifTrajetPrive[] Returns an array of NotifReponse objects
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

//    public function findOneBySomeField($value): ?NotifTrajetPrive
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
