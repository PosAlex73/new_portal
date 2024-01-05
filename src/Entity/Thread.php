<?php

namespace App\Entity;

use App\Repository\ThreadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThreadRepository::class)]
class Thread
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'thread', targetEntity: ThreadMessage::class, orphanRemoval: true)]
    private Collection $threadMessages;

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
}
