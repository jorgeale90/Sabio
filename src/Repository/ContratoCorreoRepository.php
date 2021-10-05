<?php

namespace App\Repository;

use App\Entity\ContratoCorreo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContratoCorreo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContratoCorreo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContratoCorreo[]    findAll()
 * @method ContratoCorreo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratoCorreoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratoCorreo::class);
    }

    // /**
    //  * @return ContratoCorreo[] Returns an array of ContratoCorreo objects
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
    public function findOneBySomeField($value): ?ContratoCorreo
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
