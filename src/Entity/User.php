<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 30, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Table::class, mappedBy: 'players')]
    private Collection $gameTables;

    #[ORM\OneToMany(mappedBy: 'master', targetEntity: Table::class)]
    private Collection $masterTables;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: Character::class)]
    private Collection $characters;

    public function __construct()
    {
        $this->gameTables = new ArrayCollection();
        $this->masterTables = new ArrayCollection();
        $this->characters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Table>
     */
    public function getGameTables(): Collection
    {
        return $this->gameTables;
    }

    public function addGameTable(Table $gameTable): self
    {
        if (!$this->gameTables->contains($gameTable)) {
            $this->gameTables->add($gameTable);
            $gameTable->addPlayer($this);
        }

        return $this;
    }

    public function removeGameTable(Table $gameTable): self
    {
        if ($this->gameTables->removeElement($gameTable)) {
            $gameTable->removePlayer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Table>
     */
    public function getMasterTables(): Collection
    {
        return $this->masterTables;
    }

    public function addMasterTable(Table $masterTable): self
    {
        if (!$this->masterTables->contains($masterTable)) {
            $this->masterTables->add($masterTable);
            $masterTable->setMaster($this);
        }

        return $this;
    }

    public function removeMasterTable(Table $masterTable): self
    {
        if ($this->masterTables->removeElement($masterTable)) {
            // set the owning side to null (unless already changed)
            if ($masterTable->getMaster() === $this) {
                $masterTable->setMaster(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->setPlayer($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getPlayer() === $this) {
                $character->setPlayer(null);
            }
        }

        return $this;
    }
}
