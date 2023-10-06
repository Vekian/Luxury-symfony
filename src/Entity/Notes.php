<?php

namespace App\Entity;

use App\Repository\NotesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotesRepository::class)]
class Notes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3000, nullable: true)]
    private ?string $content = null;
    #[ORM\OneToOne(mappedBy: 'notes', cascade: ['persist', 'remove'])]
    private ?Client $client = null;
    #[ORM\OneToOne(mappedBy: 'notes', cascade: ['persist', 'remove'])]
    private ?Candidate $candidate = null;
    #[ORM\OneToOne(mappedBy: 'notes', cascade: ['persist'])]
    private ?JobOffer $jobOffer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }
    public function __toString()
    {
        return (string) $this->content; // Replace 'yourProperty' with the property you want to display as a string.
    }

    /**
     * Get the value of candidate
     */
    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    /**
     * Set the value of candidate
     */
    public function setCandidate(?Candidate $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    /**
     * Get the value of client
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * Set the value of client
     */
    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get the value of jobOffer
     */
    public function getJobOffer(): ?JobOffer
    {
        return $this->jobOffer;
    }

    /**
     * Set the value of jobOffer
     */
    public function setJobOffer(?JobOffer $jobOffer): self
    {
        $this->jobOffer = $jobOffer;

        return $this;
    }
}
