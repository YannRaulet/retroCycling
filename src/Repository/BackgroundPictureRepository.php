<?php

namespace App\Repository;

use App\Entity\BackgroundPicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BackgroundPicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method BackgroundPicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method BackgroundPicture[]    findAll()
 * @method BackgroundPicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BackgroundPictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BackgroundPicture::class);
    }

    // /**
    //  * @return BackgroundPicture[] Returns an array of BackgroundPicture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BackgroundPicture
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
