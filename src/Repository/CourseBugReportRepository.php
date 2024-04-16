<?php

namespace App\Repository;

use App\Entity\CourseBugReport;
use App\Entity\User;
use App\Enums\Settings\SettingEnum;
use App\Services\Settings\Set;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CourseBugReport>
 *
 * @method CourseBugReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseBugReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseBugReport[]    findAll()
 * @method CourseBugReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseBugReportRepository extends ServiceEntityRepository
{
    public function __construct(
        protected ManagerRegistry $registry,
        protected Set $set
    )
    {
        parent::__construct($registry, CourseBugReport::class);
    }

    public function checkUserCreatedManyReports(User $user)
    {
        $userReportsCounts = $this->count([
            'reporter' => $user->getId()
        ]);

        $maxReports = $this->set->get(SettingEnum::MAX_REPORTS);
        return $userReportsCounts === (int) $maxReports->getId();
    }
}
