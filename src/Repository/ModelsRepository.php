<?php

namespace App\Repository;

use App\Entity\Models;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Models|null find($id, $lockMode = null, $lockVersion = null)
 * @method Models|null findOneBy(array $criteria, array $orderBy = null)
 * @method Models[]    findAll()
 * @method Models[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Models::class);
    }

    // /**
    //  * @return Models[] Returns an array of Models objects
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
    public function findOneBySomeField($value): ?Models
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
