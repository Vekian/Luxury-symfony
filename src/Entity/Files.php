<?php

namespace App\Entity;

use App\Repository\FilesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilesRepository::class)]
class Files
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2000)]
    private ?string $source = null;

    #[ORM\OneToOne(mappedBy: 'passportFile', cascade: ['persist', 'remove'])]
    private ?Candidate $candidate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        $this->source = $source;

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
            $this->candidate->setPassportFile(null);
        }

        // set the owning side of the relation if necessary
        if ($candidate !== null && $candidate->getPassportFile() !== $this) {
            $candidate->setPassportFile($this);
        }

        $this->candidate = $candidate;

        return $this;
    }
    public function __toString()
    {
        return (string) $this->source; // Replace 'yourProperty' with the property you want to display as a string.
    }
}
