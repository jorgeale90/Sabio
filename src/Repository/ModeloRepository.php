<?php

namespace App\Repository;

use App\Entity\Modelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Modelo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Modelo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Modelo[]    findAll()
 * @method Modelo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModeloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Modelo::class);
    }

    public function findByMarca($marca_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Modelo m WHERE m.marca = :marca_id');
        $consulta->setParameter('marca_id', $marca_id);
        return $consulta->getArrayResult();
    }

    // /**
    //  * @return Modelo[] Returns an array of Modelo objects
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
    public function findOneBySomeField($value): ?Modelo
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
