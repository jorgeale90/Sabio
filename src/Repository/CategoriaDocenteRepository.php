<?php

namespace App\Repository;

use App\Entity\CategoriaDocente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriaDocente|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriaDocente|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriaDocente[]    findAll()
 * @method CategoriaDocente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaDocenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriaDocente::class);
    }

    // /**
    //  * @return CategoriaDocente[] Returns an array of CategoriaDocente objects
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
    public function findOneBySomeField($value): ?CategoriaDocente
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
