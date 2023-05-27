<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`game_character`')]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $npc = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    private ?User $player = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Table $gameTable = null;

    #[ORM\Column(length: 255)]
    private ?string $ethnicity = null;

    #[ORM\Column(length: 50)]
    private ?string $culture = null;

    #[ORM\Column(length: 20)]
    private ?string $characterClass = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isNpc(): ?bool
    {
        return $this->npc;
    }

    public function setNpc(bool $npc): self
    {
        $this->npc = $npc;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getGameTable(): ?Table
    {
        return $this->gameTable;
    }

    public function setGameTable(?Table $gameTable): self
    {
        $this->gameTable = $gameTable;

        return $this;
    }

    public function getEthnicity(): ?string
    {
        return $this->ethnicity;
    }

    public function setEthnicity(string $ethnicity): self
    {
        $this->ethnicity = $ethnicity;

        return $this;
    }

    public function getCulture(): ?string
    {
        return $this->culture;
    }

    public function setCulture(string $culture): self
    {
        $this->culture = $culture;

        return $this;
    }

    public function getCharacterClass(): ?string
    {
        return $this->characterClass;
    }

    public function setCharacterClass(string $characterClass): self
    {
        $this->characterClass = $characterClass;

        return $this;
    }
}
