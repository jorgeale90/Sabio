<?php

namespace App\Repository;

use App\Entity\AuditoriaInterna;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AuditoriaInterna|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuditoriaInterna|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuditoriaInterna[]    findAll()
 * @method AuditoriaInterna[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditoriaInternaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuditoriaInterna::class);
    }

    // /**
    //  * @return AuditoriaInterna[] Returns an array of AuditoriaInterna objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AuditoriaInterna
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
