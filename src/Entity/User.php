<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 1)]
    private ?string $status = null;

    #[ORM\Column(length: 1)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Thread $thread = null;

    #[ORM\OneToOne(mappedBy: 'owner', cascade: ['persist', 'remove'])]
    private ?UserProfile $userProfile = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: UserProgress::class)]
    private Collection $userProgress;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'reporter', targetEntity: CourseBugReport::class)]
    private Collection $courseBugReports;

    #[ORM\OneToOne(mappedBy: 'user_like', cascade: ['persist', 'remove'])]
    private ?FavoriteCourse $favoriteCourse = null;

    public function __construct()
    {
        $this->userProgress = new ArrayCollection();
        $this->courseBugReports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

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

    public function getThread(): ?Thread
    {
        return $this->thread;
    }

    public function setThread(?Thread $thread): static
    {
        $this->thread = $thread;

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

    public function getUserProfile(): ?UserProfile
    {
        return $this->userProfile;
    }

    public function setUserProfile(?UserProfile $userProfile): static
    {
        // unset the owning side of the relation if necessary
        if ($userProfile === null && $this->userProfile !== null) {
            $this->userProfile->setOwner(null);
        }

        // set the owning side of the relation if necessary
        if ($userProfile !== null && $userProfile->getOwner() !== $this) {
            $userProfile->setOwner($this);
        }

        $this->userProfile = $userProfile;

        return $this;
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
            $userProgress->setOwner($this);
        }

        return $this;
    }

    public function removeUserProgress(UserProgress $userProgress): static
    {
        if ($this->userProgress->removeElement($userProgress)) {
            // set the owning side to null (unless already changed)
            if ($userProgress->getOwner() === $this) {
                $userProgress->setOwner(null);
            }
        }

        return $this;
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

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
            $courseBugReport->setReporter($this);
        }

        return $this;
    }

    public function removeCourseBugReport(CourseBugReport $courseBugReport): static
    {
        if ($this->courseBugReports->removeElement($courseBugReport)) {
            // set the owning side to null (unless already changed)
            if ($courseBugReport->getReporter() === $this) {
                $courseBugReport->setReporter(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }

    public function getFavoriteCourse(): ?FavoriteCourse
    {
        return $this->favoriteCourse;
    }

    public function setFavoriteCourse(?FavoriteCourse $favoriteCourse): static
    {
        // unset the owning side of the relation if necessary
        if ($favoriteCourse === null && $this->favoriteCourse !== null) {
            $this->favoriteCourse->setUserLike(null);
        }

        // set the owning side of the relation if necessary
        if ($favoriteCourse !== null && $favoriteCourse->getUserLike() !== $this) {
            $favoriteCourse->setUserLike($this);
        }

        $this->favoriteCourse = $favoriteCourse;

        return $this;
    }
}
