<?php

namespace App\Entity;

use App\Repository\RealisedServiceUsedItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RealisedServiceUsedItemRepository::class)]
class RealisedServiceUsedItem
{
    use \Gedmo\Timestampable\Traits\TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\ManyToOne(targetEntity: RealisedService::class, inversedBy: 'realisedServiceUsedItems')]
    private $realisedService;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRealisedService(): ?RealisedService
    {
        return $this->realisedService;
    }

    public function setRealisedService(?RealisedService $realisedService): self
    {
        $this->realisedService = $realisedService;

        return $this;
    }
}
