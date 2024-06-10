<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamsRepository::class)]
class Teams
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Peoples>
     */
    #[ORM\ManyToMany(targetEntity: Peoples::class, mappedBy: 'teams')]
    private Collection $peoples;

    public function __construct()
    {
        $this->peoples = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable(); // Set default current timestamp
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Peoples>
     */
    public function getPeoples(): Collection
    {
        return $this->peoples;
    }

    public function addPeople(Peoples $people): static
    {
        if (!$this->peoples->contains($people)) {
            $this->peoples->add($people);
            $people->addTeam($this);
        }

        return $this;
    }

    public function removePeople(Peoples $people): static
    {
        if ($this->peoples->removeElement($people)) {
            $people->removeTeam($this);
        }

        return $this;
    }
}
