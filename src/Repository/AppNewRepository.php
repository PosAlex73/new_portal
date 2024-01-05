<?php

namespace App\Repository;

use App\Entity\AppNew;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppNew>
 *
 * @method AppNew|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppNew|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppNew[]    findAll()
 * @method AppNew[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppNewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppNew::class);
    }

//    /**
//     * @return AppNew[] Returns an array of AppNew objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AppNew
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
