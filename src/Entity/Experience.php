<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
class Experience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $duration = null;

    #[ORM\OneToOne(mappedBy: 'experience', cascade: ['persist', 'remove'])]
    private ?Candidate $candidate = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    public function setCandidate(?Candidate $candidate): static
    {
        // unset the owning side of the relation if necessary
        if ($candidate === null && $this->candidate !== null) {
            $this->candidate->setExperience(null);
        }

        // set the owning side of the relation if necessary
        if ($candidate !== null && $candidate->getExperience() !== $this) {
            $candidate->setExperience($this);
        }

        $this->candidate = $candidate;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->duration; // Replace 'yourProperty' with the property you want to display as a string.
    }

}
