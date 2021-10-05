<?php

namespace App\Repository;

use App\Entity\ContratoAnclaje;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContratoAnclaje|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContratoAnclaje|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContratoAnclaje[]    findAll()
 * @method ContratoAnclaje[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratoAnclajeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratoAnclaje::class);
    }

    // /**
    //  * @return ContratoAnclaje[] Returns an array of ContratoAnclaje objects
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
    public function findOneBySomeField($value): ?ContratoAnclaje
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
