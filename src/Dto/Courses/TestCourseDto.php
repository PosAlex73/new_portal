<?php

namespace App\Dto\Courses;

use App\Entity\Category;

class TestCourseDto
{
    public function __construct(
        protected string $courseName,
        protected Category $category)
    {}

    /**
     * @return string
     */
    public function getCourseName(): string
    {
        return $this->courseName;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }
}
