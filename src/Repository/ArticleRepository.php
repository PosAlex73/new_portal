<?php

namespace App\Repository;

use App\Entity\Article;
use App\Enums\Blog\BlogStatuses;
use App\Enums\CommonStatus;
use App\Enums\Settings\SettingEnum;
use App\Services\Settings\Set;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(
        protected ManagerRegistry $registry,
        protected PaginatorInterface $paginator,
        protected Set $set
    )
    {
        parent::__construct($registry, Article::class);
    }

    public function getForListPage(int $frontendPageNumber, int $offset = 0)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.status = :status')
            ->setParameters([
                'status' => CommonStatus::ACTIVE->value
            ])
            ->setFirstResult($offset)
            ->setMaxResults($frontendPageNumber)
            ->getQuery();

        return new Paginator($query);
    }

    public function getAnyActiveArticle()
    {
        $query = $this->createQueryBuilder('a');
        return $query
            ->where('status = :status')
            ->setParameters([
                'status' => CommonStatus::ACTIVE->value
            ])
            ->getQuery()
            ->getSingleResult();
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

    public function getPopularArticles(int $number = 5)
    {
        return $this->createQueryBuilder('a')
            ->where('a.status = :status')
            ->orderBy('a.views')
            ->setParameters([
                'status' => BlogStatuses::ACTIVE->value
            ])
            ->setMaxResults($number)
            ->getQuery()
            ->getResult();
    }
}
