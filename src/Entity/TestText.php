<?php

namespace App\Entity;

use App\Entity\Traits\DatetimeStr;
use App\Repository\TestTextRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestTextRepository::class)]
#[ORM\HasLifecycleCallbacks]
class TestText
{
    use DatetimeStr;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'testTexts')]
    private ?Task $task = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $variant_one = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $variant_two = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $variant_three = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $variant_four = null;

    #[ORM\Column]
    private ?int $right_variant = null;

    public function __construct()
    {
        $this->testVariants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): static
    {
        $this->task = $task;

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

    #[ORM\PrePersist]
    public function preCreated()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function preUpdated()
    {
        $this->updated = new \DateTime();
    }

    public function getVariantCount()
    {
        return 4;
    }

    public function getVariantOne(): ?string
    {
        return $this->variant_one;
    }

    public function setVariantOne(string $variant_one): static
    {
        $this->variant_one = $variant_one;

        return $this;
    }

    public function getVariantTwo(): ?string
    {
        return $this->variant_two;
    }

    public function setVariantTwo(string $variant_two): static
    {
        $this->variant_two = $variant_two;

        return $this;
    }

    public function getVariantThree(): ?string
    {
        return $this->variant_three;
    }

    public function setVariantThree(string $variant_three): static
    {
        $this->variant_three = $variant_three;

        return $this;
    }

    public function getVariantFour(): ?string
    {
        return $this->variant_four;
    }

    public function setVariantFour(string $variant_four): static
    {
        $this->variant_four = $variant_four;

        return $this;
    }

    public function getRightVariant(): ?int
    {
        return $this->right_variant;
    }

    public function setRightVariant(int $right_variant): static
    {
        $this->right_variant = $right_variant;

        return $this;
    }
}
