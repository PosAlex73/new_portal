<?php

namespace App\Services\Courses;

use App\Dto\Courses\InitialCourseDto;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CourseLoader
{
    protected readonly string $coursePath;

    public function __construct(protected ParameterBagInterface $parameterBag)
    {
        $this->coursePath = $this->parameterBag->get('course_test_path');
    }

    public function getCourseByName(string $tech, string $courseName)
    {
        $courseArray = $this->getCourseArray($tech, $courseName);

        return new InitialCourseDto(
            $courseArray['technology'],
            $courseArray['description'],
            $courseArray['level'],
            $courseArray['tasks'],
            $courseArray['lang']
        );
    }

    private function getCourseArray(string $tech, string $courseName)
    {
        return json_decode(file_get_contents($this->coursePath . $tech . '/' . $courseName . '.json'), true);
    }
}
