<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\UniqueConstraint(name: 'telephone_unique', columns: ['telephone'])]
#[UniqueEntity(fields: ['telephone'], message: 'Klient o podanym numerze telefonu już istnieje')]
class Client
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Numer telefonu jest wymagany')]
    #[Assert\Length(min: 9, max: 15, minMessage: 'Numer telefonu musi mieć co najmniej 9 znaków', maxMessage: 'Numer telefonu może mieć maksymalnie 15 znaków')]
    private string $telephone = '';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'client')]
    private Collection $orders;

    #[ORM\Column]
    private ?bool $isCompany = false;

    #[ORM\OneToOne(mappedBy: 'client', cascade: ['persist', 'remove'])]
    private ?Company $company = null;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection<Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrders(Order $orders): self
    {
        if (!$this->orders->contains($orders)) {
            $this->orders[] = $orders;
            $orders->setClient($this);
        }

        return $this;
    }

    public function removeOrders(Order $orders): void
    {
        if ($this->orders->removeElement($orders)) {
            // set the owning side to null (unless already changed)
            if ($orders->getClient() === $this) {
                $orders->setClient(null);
            }
        }
    }

    public function __toString(): string
    {
        return $this->name . ' ' . $this->email . ' ' . $this->telephone;
    }

    public function isCompany(): ?bool
    {
        return $this->isCompany;
    }

    public function setCompany(Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function getIsCompany(): ?bool
    {
        return $this->isCompany;
    }

    public function setIsCompany(?bool $isCompany): void
    {
        $this->isCompany = $isCompany;
    }
}
