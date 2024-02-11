<?php

namespace App\Repository;

use App\Entity\Article;
use App\Enums\CommonStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getForListPage()
    {
        return $this->createQueryBuilder('a')
            ->where('a.status = :status')
            ->setParameters([
                'status' => CommonStatus::ACTIVE->value
            ])
            ->getQuery()
            ->getResult();
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
