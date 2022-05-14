<?php

namespace App\Repository;

use App\Entity\FichaTecnica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FichaTecnica|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichaTecnica|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichaTecnica[]    findAll()
 * @method FichaTecnica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichaTecnicaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichaTecnica::class);
    }

    public function findByInstitucionm($institucion_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:FichaTecnica m WHERE m.institucion = :institucion_id');
        $consulta->setParameter('institucion_id', $institucion_id);
        return $consulta->getArrayResult();
    }

    public function findByInstituciona($institucion_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:FichaTecnica m WHERE m.institucion = :institucion_id');
        $consulta->setParameter('institucion_id', $institucion_id);
        return $consulta->getArrayResult();
    }

    // /**
    //  * @return FichaTecnica[] Returns an array of FichaTecnica objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FichaTecnica
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
