<?php

namespace App\Repository;

use App\Entity\NotifReponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NotifReponse>
 *
 * @method NotifReponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotifReponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotifReponse[]    findAll()
 * @method NotifReponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotifReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotifReponse::class);
    }

    public function save(NotifReponse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NotifReponse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return NotifReponse[] Returns an array of NotifReponse objects
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

//    public function findOneBySomeField($value): ?NotifReponse
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
