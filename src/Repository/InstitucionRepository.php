<?php

namespace App\Repository;

use App\Entity\Institucion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Institucion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Institucion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Institucion[]    findAll()
 * @method Institucion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstitucionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Institucion::class);
    }

    public function findByMunicipioca($municipio_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Institucion m WHERE m.municipio = :municipio_id');
        $consulta->setParameter('municipio_id', $municipio_id);
        return $consulta->getArrayResult();
    }

    public function findByMunicipiocc($municipio_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Institucion m WHERE m.municipio = :municipio_id');
        $consulta->setParameter('municipio_id', $municipio_id);
        return $consulta->getArrayResult();
    }

    public function findByMunicipioci($municipio_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Institucion m WHERE m.municipio = :municipio_id');
        $consulta->setParameter('municipio_id', $municipio_id);
        return $consulta->getArrayResult();
    }

    public function findByMunicipioft($municipio_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Institucion m WHERE m.municipio = :municipio_id');
        $consulta->setParameter('municipio_id', $municipio_id);
        return $consulta->getArrayResult();
    }

    public function findByMunicipioip($municipio_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Institucion m WHERE m.municipio = :municipio_id');
        $consulta->setParameter('municipio_id', $municipio_id);
        return $consulta->getArrayResult();
    }

    public function findByMunicipiomr($municipio_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Institucion m WHERE m.municipio = :municipio_id');
        $consulta->setParameter('municipio_id', $municipio_id);
        return $consulta->getArrayResult();
    }

    public function findByMunicipiopm($municipio_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Institucion m WHERE m.municipio = :municipio_id');
        $consulta->setParameter('municipio_id', $municipio_id);
        return $consulta->getArrayResult();
    }

    public function findByMunicipiosc($municipio_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Institucion m WHERE m.municipio = :municipio_id');
        $consulta->setParameter('municipio_id', $municipio_id);
        return $consulta->getArrayResult();
    }

    public function findByMunicipiou($municipio_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Institucion m WHERE m.municipio = :municipio_id');
        $consulta->setParameter('municipio_id', $municipio_id);
        return $consulta->getArrayResult();
    }

    public function findByMunicipiomt($municipio_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Institucion m WHERE m.municipio = :municipio_id');
        $consulta->setParameter('municipio_id', $municipio_id);
        return $consulta->getArrayResult();
    }

    public function findByMunicipiom($municipio_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Institucion m WHERE m.municipio = :municipio_id');
        $consulta->setParameter('municipio_id', $municipio_id);
        return $consulta->getArrayResult();
    }

    public function findByMunicipioa($municipio_id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT m FROM App:Institucion m WHERE m.municipio = :municipio_id');
        $consulta->setParameter('municipio_id', $municipio_id);
        return $consulta->getArrayResult();
    }

    // /**
    //  * @return Institucion[] Returns an array of Institucion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Institucion
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
