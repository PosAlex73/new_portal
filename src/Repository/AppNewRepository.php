<?php

namespace App\Repository;

use App\Entity\AppNew;
use App\Enums\CommonStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppNew>
 *
 * @method AppNew|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppNew|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppNew[]    findAll()
 * @method AppNew[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppNewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppNew::class);
    }

    public function getForListPage()
    {
        return $this->createQueryBuilder('n')
            ->where('n.status = :status')
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
            ->setParameter('text', "%$text%")
            ->getQuery()
            ->getResult();
    }
}
