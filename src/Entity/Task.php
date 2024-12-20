<?php

namespace App\Entity;

use App\Enums\CommonStatus;
use App\Enums\Task\TaskTypes;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(length: 1)]
    private ?string $status = null;

    #[ORM\Column(length: 1)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?Course $course = null;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: TestText::class)]
    private Collection $testTexts;

    public function __construct()
    {
        $this->testTexts = new ArrayCollection();
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

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

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function getShortText()
    {
        return substr($this->getText(), 0, 100) . '...';
    }

    public function getTypeStr()
    {
        return match($this->getType()) {
            TaskTypes::TEST->value => 'Тест',
            TaskTypes::THEORY->value => 'Теория',
            TaskTypes::PRACTICE->value => 'Практика',
        };
    }

    public function getStatusStr()
    {
        return match ($this->getStatus()) {
            CommonStatus::ACTIVE->value => "Активно",
            CommonStatus::DISABLED->value => "Отключено"
        };
    }

    /**
     * @return Collection<int, TestText>
     */
    public function getTestTexts(): Collection
    {
        return $this->testTexts;
    }

    public function addTestText(TestText $testText): static
    {
        if (!$this->testTexts->contains($testText)) {
            $this->testTexts->add($testText);
            $testText->setTask($this);
        }

        return $this;
    }

    public function removeTestText(TestText $testText): static
    {
        if ($this->testTexts->removeElement($testText)) {
            // set the owning side to null (unless already changed)
            if ($testText->getTask() === $this) {
                $testText->setTask(null);
            }
        }

        return $this;
    }
}
