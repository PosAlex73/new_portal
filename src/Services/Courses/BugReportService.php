<?php

namespace App\Services\Courses;

use App\Entity\CourseBugReport;
use App\Enums\Courses\BugStatus;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class BugReportService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected Security $security
    ){}

    public function saveBugReport(CourseBugReport $courseBugReport)
    {
        $user = $this->security->getUser();
        $courseBugReport->setReporter($user);
        $courseBugReport->setStatus(BugStatus::NEW->value);

        $this->entityManager->persist($courseBugReport);
        $this->entityManager->flush();
    }
}
