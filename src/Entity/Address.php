<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $biome = null;

    #[ORM\Column]
    private ?float $coordinate_x = null;

    #[ORM\Column]
    private ?float $coordinate_y = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'address')]
    private Collection $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBiome(): ?string
    {
        return $this->biome;
    }

    public function setBiome(string $biome): static
    {
        $this->biome = $biome;

        return $this;
    }

    public function getCoordinateX(): ?float
    {
        return $this->coordinate_x;
    }

    public function setCoordinateX(float $coordinate_x): static
    {
        $this->coordinate_x = $coordinate_x;

        return $this;
    }

    public function getCoordinateY(): ?float
    {
        return $this->coordinate_y;
    }

    public function setCoordinateY(float $coordinate_y): static
    {
        $this->coordinate_y = $coordinate_y;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setAddress($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAddress() === $this) {
                $user->setAddress(null);
            }
        }

        return $this;
    }
}
