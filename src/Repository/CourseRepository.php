<?php

namespace App\Repository;

use App\Entity\Course;
use App\Enums\Courses\CourseStatuses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
    public function __construct(ManagerRegistry $registry)
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

    public function getForCoursePage()
    {
        //fixme сделать отдельный метод

        return $this->getForIndexPage();
    }

    public function getBySearch(string $text)
    {
        $qb = $this->createQueryBuilder('c');
        return  $qb
        ->where($qb->expr()->like('c.title', ':text'))
        ->orWhere($qb->expr()->like('c.text', ':text'))
            ->setParameter('text', $text)
            ->getQuery()
            ->getResult();
    }
}
