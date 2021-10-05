<?php

namespace App\Repository;

use App\Entity\OrganizacionPolitica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrganizacionPolitica|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrganizacionPolitica|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrganizacionPolitica[]    findAll()
 * @method OrganizacionPolitica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganizacionPoliticaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrganizacionPolitica::class);
    }

    // /**
    //  * @return OrganizacionPolitica[] Returns an array of OrganizacionPolitica objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrganizacionPolitica
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
