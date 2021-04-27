<?php

namespace App\Repository;

use App\Entity\CyclingShirt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CyclingShirt|null find($id, $lockMode = null, $lockVersion = null)
 * @method CyclingShirt|null findOneBy(array $criteria, array $orderBy = null)
 * @method CyclingShirt[]    findAll()
 * @method CyclingShirt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CyclingShirtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CyclingShirt::class);
    }

    // /**
    //  * @return CyclingShirt[] Returns an array of CyclingShirt objects
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
    public function findOneBySomeField($value): ?CyclingShirt
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
