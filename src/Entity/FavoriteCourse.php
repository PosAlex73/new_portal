<?php

namespace App\Entity;

use App\Repository\FavoriteCourseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteCourseRepository::class)]
#[ORM\HasLifecycleCallbacks]
class FavoriteCourse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'favoriteCourse', cascade: ['persist', 'remove'])]
    private ?User $user_like = null;

    #[ORM\OneToOne(inversedBy: 'favoriteCourse', cascade: ['persist', 'remove'])]
    private ?Course $course = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserLike(): ?User
    {
        return $this->user_like;
    }

    public function setUserLike(?User $user_like): static
    {
        $this->user_like = $user_like;

        return $this;
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
}
