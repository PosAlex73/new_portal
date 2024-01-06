<?php

namespace App\Repository;

use App\Entity\Category;
use App\Enums\Settings\SettingEnum;
use App\Services\Settings\Set;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    protected int $elementsPerPage;

    public function __construct(
        protected Set $set, ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
        $this->elementsPerPage = $this->set->get(SettingEnum::ADMIN_PAGINATION)->getValue();
    }

    public function getWithPaginate(int $page)
    {
        $offset = $page * $this->elementsPerPage;
        $qb = $this->createQueryBuilder('c');
        return $qb
            ->setFirstResult($offset)
            ->setMaxResults($this->elementsPerPage)
            ->getQuery()
            ->getResult();

    }
}
