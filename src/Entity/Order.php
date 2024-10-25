<?php

namespace App\Entity;

use App\Enum\OrderStatus;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(enumType: OrderStatus::class)]
    private ?OrderStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'Orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'Orders')]
    private Collection $OrderItem;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $orders = null;

    public function __construct()
    {
        $this->OrderItem = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

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

    public function getStatus(): ?OrderStatus
    {
        return $this->status;
    }

    public function setStatus(OrderStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItem(): Collection
    {
        return $this->OrderItem;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->OrderItem->contains($orderItem)) {
            $this->OrderItem->add($orderItem);
            $orderItem->setOrders($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->OrderItem->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrders() === $this) {
                $orderItem->setOrders(null);
            }
        }

        return $this;
    }

    public function getOrders(): ?User
    {
        return $this->orders;
    }

    public function setOrders(?User $orders): static
    {
        $this->orders = $orders;

        return $this;
    }
}
