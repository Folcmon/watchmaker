<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Loggable\Loggable;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'orders')]
#[Gedmo\Loggable]
class Order implements Loggable
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Gedmo\Versioned]
    private ?string $description;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Gedmo\Versioned]
    private ?Client $client;

    #[ORM\Column(type: 'string', length: 255)]
    #[Gedmo\Versioned]
    private ?string $name;

    #[ORM\OneToMany(targetEntity: ServiceAttachment::class, mappedBy: 'service', cascade: ['all'], orphanRemoval: true)]
    private Collection|array $serviceAttachments;

    #[ORM\OneToMany(targetEntity: RealisedServiceUsedItem::class, mappedBy: 'realisedService', cascade: [
        'persist',
        'remove'
    ])]
    private Collection $realisedServiceUsedItems;

    #[ORM\Column(length: 255)]
    #[Gedmo\Versioned]
    private ?string $status = null;

    #[ORM\Column(type: 'integer')]
    #[Gedmo\Versioned]
    private int $labor = 0;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?VatRate $laborVatRate = null;

    public function __construct()
    {
        $this->serviceAttachments = new ArrayCollection();
        $this->realisedServiceUsedItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
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

    /**
     * @return Collection
     */
    public function getServiceAttachments(): Collection
    {
        return $this->serviceAttachments;
    }

    public function addServiceAttachment(ServiceAttachment $serviceAttachment): self
    {
        if (!$this->serviceAttachments->contains($serviceAttachment)) {
            $this->serviceAttachments[] = $serviceAttachment;
            $serviceAttachment->setService($this);
        }

        return $this;
    }

    public function removeServiceAttachment(ServiceAttachment $serviceAttachment): self
    {
        if ($this->serviceAttachments->removeElement($serviceAttachment)) {
            // set the owning side to null (unless already changed)
            if ($serviceAttachment->getService() === $this) {
                $serviceAttachment->setService(null);
            }
        }

        return $this;
    }

    public function addRealisedServiceUsedItem(RealisedServiceUsedItem $realisedServiceUsedItem): self
    {
        if (!$this->realisedServiceUsedItems->contains($realisedServiceUsedItem)) {
            $this->realisedServiceUsedItems[] = $realisedServiceUsedItem;
            $realisedServiceUsedItem->setRealisedService($this);
        }

        return $this;
    }

    public function removeRealisedServiceUsedItem(RealisedServiceUsedItem $realisedServiceUsedItem): self
    {
        if ($this->realisedServiceUsedItems->removeElement($realisedServiceUsedItem)) {
            // set the owning side to null (unless already changed)
            if ($realisedServiceUsedItem->getRealisedService() === $this) {
                $realisedServiceUsedItem->setRealisedService(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getLabor(): float
    {
        return $this->labor / 100;
    }

    public function setLabor(float $labor): static
    {
        $this->labor = $labor * 100;

        return $this;
    }

    public function getTotalPrice(): float
    {
        $totalPrice = $this->labor * (1 + $this->getLaborVatRate()->getRateValue() / 100);
        foreach ($this->getRealisedServiceUsedItems() as $realisedServiceUsedItem) {
            $totalPrice += $realisedServiceUsedItem->getTotalPrice();
        }
        return $totalPrice;
    }

    public function getLaborVatRate(): ?VatRate
    {
        return $this->laborVatRate;
    }

    public function setLaborVatRate(?VatRate $laborVatRate): static
    {
        $this->laborVatRate = $laborVatRate;

        return $this;
    }

    /**
     * @return Collection <RealisedServiceUsedItem>
     */
    public function getRealisedServiceUsedItems(): Collection
    {
        return $this->realisedServiceUsedItems;
    }
}
