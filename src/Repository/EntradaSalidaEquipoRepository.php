<?php

namespace App\Repository;

use App\Entity\EntradaSalidaEquipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EntradaSalidaEquipo|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntradaSalidaEquipo|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntradaSalidaEquipo[]    findAll()
 * @method EntradaSalidaEquipo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntradaSalidaEquipoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntradaSalidaEquipo::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(EntradaSalidaEquipo $entity, bool $flush = true): void
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
    public function remove(EntradaSalidaEquipo $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return EntradaSalidaEquipo[] Returns an array of EntradaSalidaEquipo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EntradaSalidaEquipo
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
