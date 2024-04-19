<?php

namespace App\Repository;

use App\Entity\UserProgress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
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
    public function __construct(
        protected ManagerRegistry $registry,
        protected UserRepository $userRepository
    )
    {
        parent::__construct($registry, UserProgress::class);
    }

    public function getByUserProgress(int $userId, int $courseId, bool $singleResult = false)
    {
        $qb = $this->createQueryBuilder('up')
            ->where('up.owner = :owner')
            ->andWhere('up.course = :course')
            ->setParameters([
                'owner' => $userId,
                'course' => $courseId
            ])
            ->getQuery();

        if ($singleResult) {
            return $qb->getSingleResult();
        } else {
            return $qb->getResult();
        }
    }

    public function getCourseIdsByUserId(int $userId): array
    {
        $qb = $this->createQueryBuilder('p');
        $result = $qb
            ->select('p.id')
            ->where('p.owner = :user')
            ->setParameters([
                'user' => $userId
            ])
            ->getQuery()
            ->getResult();

        return array_column($result, 'id');
    }

    public function getProgressByUserId(int $userId)
    {
        return $this->findBy([
            'owner' => $userId
        ]);
    }

    public function getByUserEmail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            return [];
        }

        return $this->findBy([
            'owner' => $user->getId()
        ]);
    }
}
