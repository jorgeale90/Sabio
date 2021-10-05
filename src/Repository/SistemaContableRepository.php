<?php

namespace App\Repository;

use App\Entity\SistemaContable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SistemaContable|null find($id, $lockMode = null, $lockVersion = null)
 * @method SistemaContable|null findOneBy(array $criteria, array $orderBy = null)
 * @method SistemaContable[]    findAll()
 * @method SistemaContable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SistemaContableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SistemaContable::class);
    }

    // /**
    //  * @return SistemaContable[] Returns an array of SistemaContable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SistemaContable
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
