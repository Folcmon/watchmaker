<?php

namespace App\Entity;

use App\Repository\RealisedServiceUsedItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: RealisedServiceUsedItemRepository::class)]
class RealisedServiceUsedItem
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'integer')]
    private ?int $quantity;

    #[ORM\Column(type: 'integer')]
    private int $price = 0;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'realisedServiceUsedItems')]
    private ?Order $realisedService;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Storage $storage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRealisedService(): ?Order
    {
        return $this->realisedService;
    }

    public function setRealisedService(?Order $realisedService): self
    {
        $this->realisedService = $realisedService;

        return $this;
    }

    public function getTotalPrice(): int
    {
        return $this->price * $this->quantity;
    }

    public function getStorage(): ?Storage
    {
        return $this->storage;
    }

    public function setStorage(?Storage $storage): static
    {
        $this->storage = $storage;

        return $this;
    }
}
