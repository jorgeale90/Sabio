<?php

namespace App\Repository;

use App\Entity\MantenimientoReparacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MantenimientoReparacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method MantenimientoReparacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method MantenimientoReparacion[]    findAll()
 * @method MantenimientoReparacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MantenimientoReparacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MantenimientoReparacion::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(MantenimientoReparacion $entity, bool $flush = true): void
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
    public function remove(MantenimientoReparacion $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return MantenimientoReparacion[] Returns an array of MantenimientoReparacion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MantenimientoReparacion
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
