<?php

namespace App\Services\Courses\Export;

use App\Entity\Course;
use App\Enums\Courses\ImportTypes;
use App\Repository\CourseRepository;
use Symfony\Component\Serializer\SerializerInterface;

class CourseExportService
{
    public function __construct(
        private CourseRepository $courseRepository,
        private SerializerInterface $serializer
    )
    {}

    public function exportAllCourses(ImportTypes $importTypes = ImportTypes::JSON): string
    {
        /** @var array<Course> $courses */
        $courses = $this->courseRepository->findAll();
        return $this->export($courses, $importTypes);
    }

    public function exportCourses(array $courses, ImportTypes $importTypes = ImportTypes::JSON): string
    {
        return $this->export($courses, $importTypes);
    }

    private function exportResolver(ImportTypes $importTypes): ExporterInterface
    {
        return match ($importTypes) {
            ImportTypes::JSON => new JsonExporter(),
            default => throw new \Exception('Данный тип экпортера курсов еще не реализован!')
        };
    }

    private function export(array $courses, ImportTypes $importTypes): string
    {
        return $this->exportResolver($importTypes)->exportedCourses($courses, $this->serializer);
    }
}
