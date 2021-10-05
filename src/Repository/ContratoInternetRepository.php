<?php

namespace App\Repository;

use App\Entity\ContratoInternet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContratoInternet|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContratoInternet|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContratoInternet[]    findAll()
 * @method ContratoInternet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratoInternetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratoInternet::class);
    }

    // /**
    //  * @return ContratoInternet[] Returns an array of ContratoInternet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContratoInternet
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
