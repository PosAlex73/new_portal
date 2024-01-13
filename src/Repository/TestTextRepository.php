<?php

namespace App\Repository;

use App\Entity\TestText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestText>
 *
 * @method TestText|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestText|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestText[]    findAll()
 * @method TestText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestTextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestText::class);
    }

//    /**
//     * @return TestText[] Returns an array of TestText objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TestText
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
