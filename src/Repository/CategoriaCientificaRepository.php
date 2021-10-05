<?php

namespace App\Repository;

use App\Entity\CategoriaCientifica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriaCientifica|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriaCientifica|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriaCientifica[]    findAll()
 * @method CategoriaCientifica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaCientificaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriaCientifica::class);
    }

    // /**
    //  * @return CategoriaCientifica[] Returns an array of CategoriaCientifica objects
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
    public function findOneBySomeField($value): ?CategoriaCientifica
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
