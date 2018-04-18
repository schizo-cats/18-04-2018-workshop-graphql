<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlanetRepository")
 */
class Planet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-planet", "astronaut-register"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-planet"})
     */
    private $uuid;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"get-planet"})
     */
    private $attack;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"get-planet"})
     */
    private $defense;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Astronaut", mappedBy="planet")
     * @Groups({"get-planet"})
     */
    private $astronauts;

    public function __construct()
    {
        $this->astronauts = new ArrayCollection();
    }

    public function getId()
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

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): self
    {
        $this->defense = $defense;

        return $this;
    }

    /**
     * @return Collection|Astronaut[]
     */
    public function getAstronauts(): Collection
    {
        return $this->astronauts;
    }

    public function addAstronaut(Astronaut $astronaut): self
    {
        if (!$this->astronauts->contains($astronaut)) {
            $this->astronauts[] = $astronaut;
            $astronaut->setPlanet($this);
        }

        return $this;
    }

    public function removeAstronaut(Astronaut $astronaut): self
    {
        if ($this->astronauts->contains($astronaut)) {
            $this->astronauts->removeElement($astronaut);
            // set the owning side to null (unless already changed)
            if ($astronaut->getPlanet() === $this) {
                $astronaut->setPlanet(null);
            }
        }

        return $this;
    }
}
