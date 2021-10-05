<?php

namespace App\Repository;

use App\Entity\TipoMedio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoMedio|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoMedio|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoMedio[]    findAll()
 * @method TipoMedio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoMedioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoMedio::class);
    }

    // /**
    //  * @return TipoMedio[] Returns an array of TipoMedio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TipoMedio
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
