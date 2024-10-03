<?php

namespace App\Entity;

use App\Repository\ThreadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThreadRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Thread
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'thread', targetEntity: ThreadMessage::class, orphanRemoval: true)]
    private Collection $threadMessages;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    public function __construct()
    {
        $this->threadMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, ThreadMessage>
     */
    public function getThreadMessages(): Collection
    {
        return $this->threadMessages;
    }

    public function addThreadMessage(ThreadMessage $threadMessage): static
    {
        if (!$this->threadMessages->contains($threadMessage)) {
            $this->threadMessages->add($threadMessage);
            $threadMessage->setThread($this);
        }

        return $this;
    }

    public function removeThreadMessage(ThreadMessage $threadMessage): static
    {
        if ($this->threadMessages->removeElement($threadMessage)) {
            // set the owning side to null (unless already changed)
            if ($threadMessage->getThread() === $this) {
                $threadMessage->setThread(null);
            }
        }

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

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): static
    {
        $this->updated = $updated;

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
}
