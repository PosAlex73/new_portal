<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\User;
use App\Entity\UserProgress;
use App\Enums\Courses\CourseStatuses;
use App\Enums\Settings\SettingEnum;
use App\Services\Settings\Set;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Course>
 *
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(
        protected ManagerRegistry $registry,
        protected PaginatorInterface $paginator,
        protected Set $set
    )
    {
        parent::__construct($registry, Course::class);
    }

    public function getForIndexPage()
    {
        return $this->createQueryBuilder('c')
            ->where('c.status = :status')
            ->setParameters([
                'status' => CourseStatuses::ACTIVE->value
            ])
            ->getQuery()
            ->getResult();
    }

    public function paginate(int $frontendPageNumber, int $offset = 0)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.status = :status')
            ->setParameters([
                'status' => CourseStatuses::ACTIVE->value
            ])
            ->setMaxResults($frontendPageNumber)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function getBySearch(string $text)
    {
        $qb = $this->createQueryBuilder('c');

        return  $qb
        ->where($qb->expr()->like('c.title', ':text'))
        ->orWhere($qb->expr()->like('c.text', ':text'))
            ->setParameter('text', "%$text%")
            ->getQuery()
            ->getResult();
    }

    public function getPopularCourses(int $number = 5)
    {
        return $this
            ->createQueryBuilder('c')
            ->where('c.status = :status')
            ->setParameters([
                'status' => CourseStatuses::ACTIVE->value
            ])
            ->orderBy('c.position')
            ->setMaxResults($number)
            ->getQuery()
            ->getResult();
    }
}
