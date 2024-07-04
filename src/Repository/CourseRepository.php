<?php

namespace App\Repository;

use App\Entity\Course;
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

    public function paginate(int $page = 1)
    {
        $frontendPageNumber = $this->set->get(SettingEnum::FRONT_PAGINATION);
        $query = $this->createQueryBuilder('c')
            ->where('c.status = :status')
            ->setParameters([
                'status' => CourseStatuses::ACTIVE->value
            ])
            ->getQuery();

        return $this->paginator->paginate($query, $page, $frontendPageNumber->getValue());
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
}
