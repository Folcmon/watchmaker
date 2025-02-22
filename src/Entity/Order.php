<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'orders')]
class Order
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $description;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\OneToMany(targetEntity: OrderAttachment::class, mappedBy: 'order', cascade: ['all'], orphanRemoval: true)]
    private Collection|array $orderAttachments;

    #[ORM\OneToMany(targetEntity: RealisedServiceUsedItem::class, mappedBy: 'realisedService', cascade: [
        'persist',
        'remove'
    ])]
    private Collection $realisedServiceUsedItems;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: 'integer')]
    private int $labor = 0;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?VatRate $laborVatRate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => '2024-12-03 09:37:06'])]
    private ?\DateTimeInterface $orderAcceptanceDate = null;

    /**
     * @var Collection<int, Document>
     */
    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'associated_order', orphanRemoval: true)]
    private Collection $document;

    public function __construct()
    {
        $this->orderAttachments = new ArrayCollection();
        $this->realisedServiceUsedItems = new ArrayCollection();
        $this->document = new ArrayCollection();
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
    public function getOrderAttachments(): Collection
    {
        return $this->orderAttachments;
    }

    public function addOrderAttachment(OrderAttachment $orderAttachment): self
    {
        if (!$this->orderAttachments->contains($orderAttachment)) {
            $this->orderAttachments[] = $orderAttachment;
            $orderAttachment->setOrder($this);
        }

        return $this;
    }

    public function removeOrderAttachment(OrderAttachment $orderAttachment): self
    {
        if ($this->orderAttachments->removeElement($orderAttachment)) {
            // set the owning side to null (unless already changed)
            if ($orderAttachment->getOrder() === $this) {
                $orderAttachment->setOrder(null);
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

    public function getOrderAcceptanceDate(): ?\DateTimeInterface
    {
        return $this->orderAcceptanceDate;
    }

    public function setOrderAcceptanceDate(\DateTimeInterface $orderAcceptanceDate): static
    {
        $this->orderAcceptanceDate = $orderAcceptanceDate;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocument(): Collection
    {
        return $this->document;
    }

    public function addDocument(Document $type): static
    {
        if (!$this->document->contains($type)) {
            $this->document->add($type);
            $type->setAssociatedOrder($this);
        }

        return $this;
    }

    public function removeDocument(Document $type): static
    {
        if ($this->document->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getAssociatedOrder() === $this) {
                $type->setAssociatedOrder(null);
            }
        }
        return $this;
    }
}
