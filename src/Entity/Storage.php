<?php

namespace App\Entity;

use App\Repository\StorageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: StorageRepository::class)]
#[ORM\UniqueConstraint(name: 'name_unique', columns: ['name'])]
class Storage
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'integer')]
    private ?int $quantity;

    #[ORM\Column(type: 'integer')]
    private ?int $alarmQuantity;

    #[ORM\Column(type: 'integer')]
    private int $price = 0;

    #[ORM\Column(type: 'decimal')]
    private string $margin = '0.0';

    /**
     * @var Collection<int, StorageAttachment>
     */
    #[ORM\OneToMany(targetEntity: StorageAttachment::class, mappedBy: 'storage', orphanRemoval: true)]
    private Collection $storageAttachments;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?vatRate $vatRate = null;

    public function __construct()
    {
        $this->storageAttachments = new ArrayCollection();
    }

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

    public function getAlarmQuantity(): ?int
    {
        return $this->alarmQuantity;
    }

    public function setAlarmQuantity(int $alarmQuantity): self
    {
        $this->alarmQuantity = $alarmQuantity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice(): float
    {
        return $this->price / 100;
    }

    /**
     * @param mixed $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price * 100;
    }

    /**
     * @return string
     */
    public function getMargin(): string
    {
        return $this->margin;
    }

    /**
     * @param float $margin
     */
    public function setMargin(string $margin): void
    {
        $this->margin = $margin;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection<int, StorageAttachment>
     */
    public function getStorageAttachments(): Collection
    {
        return $this->storageAttachments;
    }

    public function addStorageAttachment(StorageAttachment $storageAttachment): static
    {
        if (!$this->storageAttachments->contains($storageAttachment)) {
            $this->storageAttachments->add($storageAttachment);
            $storageAttachment->setStorage($this);
        }

        return $this;
    }

    public function removeStorageAttachment(StorageAttachment $storageAttachment): static
    {
        if ($this->storageAttachments->removeElement($storageAttachment)) {
            // set the owning side to null (unless already changed)
            if ($storageAttachment->getStorage() === $this) {
                $storageAttachment->setStorage(null);
            }
        }

        return $this;
    }

    public function getVatRate(): ?vatRate
    {
        return $this->vatRate;
    }

    public function setVatRate(?vatRate $vatRate): static
    {
        $this->vatRate = $vatRate;

        return $this;
    }

    public function getTotalPrice(): float
    {
        return ($this->price * (1 + $this->getVatRate()->getRateValue() / 100)) * (1 + $this->margin / 100);
    }
}
