<?php

namespace App\Repository;

use App\Entity\PointIntermediaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PointIntermediaire>
 *
 * @method PointIntermediaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method PointIntermediaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method PointIntermediaire[]    findAll()
 * @method PointIntermediaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointIntermediaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PointIntermediaire::class);
    }

    public function save(PointIntermediaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PointIntermediaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PointIntermediaire[] Returns an array of PointIntermediaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PointIntermediaire
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
