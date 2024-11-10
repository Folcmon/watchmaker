<?php

namespace App\Entity;

use App\Repository\VatRateRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Describe available VAT rates in all system 23% == vatValue 23
 */
#[ORM\Entity(repositoryClass: VatRateRepository::class)]
#[ORM\UniqueConstraint(name: 'rate_name_unique', columns: ['rate_name', 'rate_value'])]
class VatRate
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $rateName = null;

    #[ORM\Column]
    private ?int $rateValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRateName(): ?string
    {
        return $this->rateName;
    }

    public function setRateName(string $rateName): self
    {
        $this->rateName = $rateName;

        return $this;
    }

    public function getRateValue(): ?int
    {
        return $this->rateValue;
    }

    public function setRateValue(int $rateValue): self
    {
        $this->rateValue = $rateValue;

        return $this;
    }

    public function __toString(): string
    {
        return $this->rateName;
    }
}
