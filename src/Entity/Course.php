<?php

namespace App\Entity;

use App\Enums\Courses\CourseStatuses;
use App\Enums\Courses\CourseTypes;
use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $short_description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    private ?Category $category = null;

    #[ORM\Column(length: 1)]
    private ?string $status = null;

    #[ORM\Column(length: 1)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: UserProgress::class)]
    private Collection $userProgress;

    #[ORM\Column(length: 255)]
    private ?string $course_code = null;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: Task::class)]
    private Collection $tasks;

    #[ORM\Column(length: 255)]
    private ?string $lang = null;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: CourseBugReport::class, orphanRemoval: true)]
    private Collection $courseBugReports;

    public function __construct()
    {
        $this->userProgress = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->courseBugReports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(?string $short_description): static
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): static
    {
        $this->updated = $updated;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    #[ORM\PreUpdate]
    public function preUpdated()
    {
        $this->updated = new \DateTime();
    }

    #[ORM\PrePersist]
    public function preCreated()
    {
        $this->preUpdated();
        $this->created = new \DateTime();
    }

    /**
     * @return Collection<int, UserProgress>
     */
    public function getUserProgress(): Collection
    {
        return $this->userProgress;
    }

    public function addUserProgress(UserProgress $userProgress): static
    {
        if (!$this->userProgress->contains($userProgress)) {
            $this->userProgress->add($userProgress);
            $userProgress->setCourse($this);
        }

        return $this;
    }

    public function removeUserProgress(UserProgress $userProgress): static
    {
        if ($this->userProgress->removeElement($userProgress)) {
            // set the owning side to null (unless already changed)
            if ($userProgress->getCourse() === $this) {
                $userProgress->setCourse(null);
            }
        }

        return $this;
    }

    public function getCourseCode(): ?string
    {
        return $this->course_code;
    }

    public function setCourseCode(string $course_code): static
    {
        $this->course_code = $course_code;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setCourse($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getCourse() === $this) {
                $task->setCourse(null);
            }
        }

        return $this;
    }

    public function getStatusStr()
    {
        return match ($this->getStatus()) {
            CourseStatuses::DISABLED->value => 'Отключен',
            CourseStatuses::ACTIVE->value => 'Активно',
            CourseStatuses::ARCHIVED->value => 'В архиве',
            CourseStatuses::IN_DEVELOPMENT->value => 'В разработке',
        };
    }

    public function getTypeStr()
    {
        return match ($this->getType()) {
            CourseTypes::FREE->value => 'Бепсплатно',
            CourseTypes::PAY->value => 'Платно'
        };
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function taskCount()
    {
        return $this->getTasks()->count();
    }

    public function getCreatedStr()
    {
        return $this->getCreated()->format('Y-m-d H:i:s');
    }

    public function getUpdatedStr()
    {
        return $this->getUpdated()->format('Y-m-d H:i:s');
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(string $lang): static
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @return Collection<int, CourseBugReport>
     */
    public function getCourseBugReports(): Collection
    {
        return $this->courseBugReports;
    }

    public function addCourseBugReport(CourseBugReport $courseBugReport): static
    {
        if (!$this->courseBugReports->contains($courseBugReport)) {
            $this->courseBugReports->add($courseBugReport);
            $courseBugReport->setCourse($this);
        }

        return $this;
    }

    public function removeCourseBugReport(CourseBugReport $courseBugReport): static
    {
        if ($this->courseBugReports->removeElement($courseBugReport)) {
            // set the owning side to null (unless already changed)
            if ($courseBugReport->getCourse() === $this) {
                $courseBugReport->setCourse(null);
            }
        }

        return $this;
    }
}
