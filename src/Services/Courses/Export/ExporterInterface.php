<?php

namespace App\Services\Courses\Export;

use Symfony\Component\Serializer\SerializerInterface;

interface ExporterInterface
{
    function exportedCourses(iterable $courses, SerializerInterface $serializer): string;
}
