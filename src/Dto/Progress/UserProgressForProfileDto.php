<?php

namespace App\Dto\Progress;

class UserProgressForProfileDto
{
    public function __construct(
        protected string $title,
        protected int $taskNumberInCourse,
        protected int $doneTasks,
        protected $startDate,
        protected $endDate,
    )
    {
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getTaskNumberInCourse(): int
    {
        return $this->taskNumberInCourse;
    }

    /**
     * @param int $taskNumberInCourse
     */
    public function setTaskNumberInCourse(int $taskNumberInCourse): void
    {
        $this->taskNumberInCourse = $taskNumberInCourse;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return int
     */
    public function getDoneTasks(): int
    {
        return $this->doneTasks;
    }

    /**
     * @param int $doneTasks
     */
    public function setDoneTasks(int $doneTasks): void
    {
        $this->doneTasks = $doneTasks;
    }


}
