<?php

namespace App\Dto\Practice;

class PracticeCodeDto
{
    public function __construct(
        protected string $code,
        protected int $courseId,
        protected int $taskId,
        protected string $lang,
    ){}

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getCourseId(): int
    {
        return $this->courseId;
    }

    /**
     * @param int $courseId
     */
    public function setCourseId(int $courseId): void
    {
        $this->courseId = $courseId;
    }

    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return $this->taskId;
    }

    /**
     * @param int $taskId
     */
    public function setTaskId(int $taskId): void
    {
        $this->taskId = $taskId;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    public function toArray()
    {
        return [
            'course_id' => $this->getCourseId(),
            'code' => $this->getCode(),
            'task_id' => $this->getTaskId(),
            'lang' => $this->getLang()
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
