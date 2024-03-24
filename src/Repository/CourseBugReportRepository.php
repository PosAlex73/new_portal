<?php

namespace App\Repository;

use App\Entity\CourseBugReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CourseBugReport>
 *
 * @method CourseBugReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseBugReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseBugReport[]    findAll()
 * @method CourseBugReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseBugReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseBugReport::class);
    }

//    /**
//     * @return CourseBugReport[] Returns an array of CourseBugReport objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CourseBugReport
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
