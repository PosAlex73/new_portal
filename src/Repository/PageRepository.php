<?php

namespace App\Repository;

use App\Entity\Page;
use App\Enums\CommonStatus;
use App\Enums\Pages\PageNames;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Page>
 *
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function getPageByName(string $name)
    {
        $name = strtolower($name);
        return $this->findOneBy([
            'name' => $name,
            'status' => CommonStatus::ACTIVE->value
        ]);
    }

    public function getJuridicalPages()
    {
        $juridicalPages = [
            PageNames::COOKIE,
            PageNames::USE_MATERIALS,
            PageNames::PERSONAL_DATA,
            PageNames::OFFER
        ];

        $juridicalPages = array_map(function (PageNames $page) {
            return $page->value;
        }, $juridicalPages);

        $qb = $this->createQueryBuilder('p');
        return $qb->where($qb->expr()->in('p.name', $juridicalPages))->getQuery()->getResult();
    }

}
