<?php

namespace App\Services\Courses\Export;

use App\Enums\Courses\ImportTypes;
use Symfony\Component\Serializer\SerializerInterface;

class JsonExporter implements ExporterInterface
{
    public function exportedCourses(iterable $courses, SerializerInterface $serializer): string
    {
        $result = [];
        foreach ($courses as $course) {
            $result[] =  $serializer->serialize($course, ImportTypes::JSON->value);
        }

        return json_encode($result);
    }
}
