<?php

namespace App\Repository;

use App\Entity\UserProgress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserProgress>
 *
 * @method UserProgress|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProgress|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProgress[]    findAll()
 * @method UserProgress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProgressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProgress::class);
    }

    public function getByUserProgress(int $userId, int $courseId)
    {
        return $this->createQueryBuilder('up')
            ->where('up.owner = :owner')
            ->andWhere('up.course = :course')
            ->setParameters([
                'owner' => $userId,
                'course' => $courseId
            ])
            ->getQuery()
            ->getResult();
    }
}
