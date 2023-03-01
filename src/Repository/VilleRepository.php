<?php

namespace App\Repository;

use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @extends ServiceEntityRepository<Ville>
 *
 * @method Ville|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ville|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ville[]    findAll()
 * @method Ville[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ville::class);
    }

    public function save(Ville $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ville $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getByID(String $id)
    {
        return $this->createQueryBuilder('v')
                ->where('v.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
    }

    /**
     * @return array<int, Ville>
     */
    public function rechercher(String $texte) : array|null
    {
        // Rien à chercher ...
        if($texte == "") return null;

        $postal = "";
        $nom = "";

        // GRP 1 : Ville
        // GRP 2 : Code Postal
        preg_match_all('/([a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý]+\.?(?:[- ][a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý]+\.?)*)/i', $texte, $matches_villes);
        preg_match_all('/([0-9]{1,5})/', $texte, $matches_postals);

        $nbMatchsVille = count($matches_villes[1]);
        $nbMatchsPostal = count($matches_postals[1]);

        // On a plusieurs matchs pour la ville ou pour le code postal ou on ne match rien, on ne sait pas quoi traiter => invalide
        if($nbMatchsVille > 1 || $nbMatchsPostal > 1 || ($nbMatchsVille == 0 && $nbMatchsPostal == 0)) return null;

        if($nbMatchsVille == 1) $nom = $matches_villes[1][0];
        if($nbMatchsPostal == 1) $postal = $matches_postals[1][0];

        $nomLower = strtolower($nom);

        $qb = $this->createQueryBuilder('v');
        if($nom != ""){
            $qb ->where('LOWER(v.ville) LIKE :nomVillePartiel')
                ->setParameter('nomVillePartiel', $nomLower.'%');
        }
        if($postal != ""){
            $qb -> andwhere('v.code_postal LIKE :postal')
                -> setParameter('postal', $postal.'%');
        }
        return $qb -> setMaxResults(5)
                   -> getQuery()
                   -> getResult();
    }

//    /**
//     * @return Ville[] Returns an array of Ville objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ville
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
