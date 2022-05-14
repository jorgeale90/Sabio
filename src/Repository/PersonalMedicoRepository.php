<?php

namespace App\Repository;

use App\Entity\PersonalMedico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PersonalMedico|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalMedico|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalMedico[]    findAll()
 * @method PersonalMedico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalMedicoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalMedico::class);
    }

    public function findByInstitucionsc($institucion_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:PersonalMedico m WHERE m.institucion = :institucion_id');
        $consulta->setParameter('institucion_id', $institucion_id);
        return $consulta->getArrayResult();
    }

    public function findByInstitucionmt($institucion_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:PersonalMedico m WHERE m.institucion = :institucion_id');
        $consulta->setParameter('institucion_id', $institucion_id);
        return $consulta->getArrayResult();
    }

    public function findByInstitucionmt2($institucion_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:PersonalMedico m WHERE m.institucion = :institucion_id');
        $consulta->setParameter('institucion_id', $institucion_id);
        return $consulta->getArrayResult();
    }

    public function findByInstitucionPm($institucion_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:PersonalMedico m WHERE m.institucion = :institucion_id');
        $consulta->setParameter('institucion_id', $institucion_id);
        return $consulta->getArrayResult();
    }

    public function findByInstitucionPm2($institucion_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:PersonalMedico m WHERE m.institucion = :institucion_id');
        $consulta->setParameter('institucion_id', $institucion_id);
        return $consulta->getArrayResult();
    }

    public function findByInstitucionPa($institucion_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:PersonalMedico m WHERE m.institucion = :institucion_id');
        $consulta->setParameter('institucion_id', $institucion_id);
        return $consulta->getArrayResult();
    }

    public function findByInstitucioncc($institucion_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:PersonalMedico m WHERE m.institucion = :institucion_id');
        $consulta->setParameter('institucion_id', $institucion_id);
        return $consulta->getArrayResult();
    }

    public function findByInstitucioncc2($institucion_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:PersonalMedico m WHERE m.institucion = :institucion_id');
        $consulta->setParameter('institucion_id', $institucion_id);
        return $consulta->getArrayResult();
    }

    // /**
    //  * @return PersonalMedico[] Returns an array of PersonalMedico objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PersonalMedico
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
