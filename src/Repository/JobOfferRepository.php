<?php

namespace App\Repository;

use App\Entity\JobOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobOffer>
 *
 * @method JobOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobOffer[]    findAll()
 * @method JobOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobOffer::class);
    }

    public function getPreviousJobOfferId($currentId)
    {
        return $this->createQueryBuilder('j')
            ->select('j.id')
            ->where('j.id < :currentId')
            ->setParameter('currentId', $currentId)
            ->orderBy('j.id', 'DESC')
            ->setMaxResults(1) // Obtenez seulement le premier résultat, qui est le précédent
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getNextJobOfferId($currentId)
    {
        return $this->createQueryBuilder('j')
            ->select('j.id')
            ->where('j.id > :currentId')
            ->setParameter('currentId', $currentId)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(1) // Obtenez seulement le premier résultat, qui est le précédent
            ->getQuery()
            ->getOneOrNullResult();
    }

    // ...

//    /**
//     * @return JobOffer[] Returns an array of JobOffer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JobOffer
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
