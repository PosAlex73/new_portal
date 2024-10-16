<?php

namespace App\Entity;

use App\Entity\Traits\PresentText;
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
    use PresentText;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
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

    /**
     * @var Collection<int, CourseLink>
     */
    #[ORM\ManyToMany(targetEntity: CourseLink::class, mappedBy: 'course')]
    private Collection $courseLinks;

    /**
     * @var Collection<int, CourseTag>
     */
    #[ORM\ManyToMany(targetEntity: CourseTag::class, mappedBy: 'courses')]
    private Collection $courseTags;

    #[ORM\Column(length: 2048, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?bool $isNew = null;

    #[ORM\OneToOne(mappedBy: 'course', cascade: ['persist', 'remove'])]
    private ?FavoriteCourse $favoriteCourse = null;

    #[ORM\ManyToOne(inversedBy: 'course')]
    private ?CourseRating $courseRating = null;

    public function __construct()
    {
        $this->userProgress = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->courseBugReports = new ArrayCollection();
        $this->courseLinks = new ArrayCollection();
        $this->courseTags = new ArrayCollection();
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

    /**
     * @return Collection<int, CourseLink>
     */
    public function getCourseLinks(): Collection
    {
        return $this->courseLinks;
    }

    public function addCourseLink(CourseLink $courseLink): static
    {
        if (!$this->courseLinks->contains($courseLink)) {
            $this->courseLinks->add($courseLink);
            $courseLink->addCourse($this);
        }

        return $this;
    }

    public function removeCourseLink(CourseLink $courseLink): static
    {
        if ($this->courseLinks->removeElement($courseLink)) {
            $courseLink->removeCourse($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, CourseTag>
     */
    public function getCourseTags(): Collection
    {
        return $this->courseTags;
    }

    public function addCourseTag(CourseTag $courseTag): static
    {
        if (!$this->courseTags->contains($courseTag)) {
            $this->courseTags->add($courseTag);
            $courseTag->addCourse($this);
        }

        return $this;
    }

    public function removeCourseTag(CourseTag $courseTag): static
    {
        if ($this->courseTags->removeElement($courseTag)) {
            $courseTag->removeCourse($this);
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function isNew(): ?bool
    {
        return $this->isNew;
    }

    public function setNew(bool $isNew): static
    {
        $this->isNew = $isNew;

        return $this;
    }

    public function getFavoriteCourse(): ?FavoriteCourse
    {
        return $this->favoriteCourse;
    }

    public function setFavoriteCourse(?FavoriteCourse $favoriteCourse): static
    {
        // unset the owning side of the relation if necessary
        if ($favoriteCourse === null && $this->favoriteCourse !== null) {
            $this->favoriteCourse->setCourse(null);
        }

        // set the owning side of the relation if necessary
        if ($favoriteCourse !== null && $favoriteCourse->getCourse() !== $this) {
            $favoriteCourse->setCourse($this);
        }

        $this->favoriteCourse = $favoriteCourse;

        return $this;
    }

    public function getCourseRating(): ?CourseRating
    {
        return $this->courseRating;
    }

    public function setCourseRating(?CourseRating $courseRating): static
    {
        $this->courseRating = $courseRating;

        return $this;
    }
}
