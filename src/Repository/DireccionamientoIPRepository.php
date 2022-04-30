<?php

namespace App\Repository;

use App\Entity\DireccionamientoIP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DireccionamientoIP|null find($id, $lockMode = null, $lockVersion = null)
 * @method DireccionamientoIP|null findOneBy(array $criteria, array $orderBy = null)
 * @method DireccionamientoIP[]    findAll()
 * @method DireccionamientoIP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DireccionamientoIPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DireccionamientoIP::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DireccionamientoIP $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(DireccionamientoIP $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return DireccionamientoIP[] Returns an array of DireccionamientoIP objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DireccionamientoIP
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
