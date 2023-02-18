<?php

namespace App\Repository;

use App\Entity\PointIntermediare;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PointIntermediare>
 *
 * @method PointIntermediare|null find($id, $lockMode = null, $lockVersion = null)
 * @method PointIntermediare|null findOneBy(array $criteria, array $orderBy = null)
 * @method PointIntermediare[]    findAll()
 * @method PointIntermediare[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointIntermediareRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PointIntermediare::class);
    }

    public function save(PointIntermediare $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PointIntermediare $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PointIntermediare[] Returns an array of PointIntermediare objects
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

//    public function findOneBySomeField($value): ?PointIntermediare
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
