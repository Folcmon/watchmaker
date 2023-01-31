<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private string $name = '';

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Order::class)]
    private Collection $orders;

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

    public function setEmail(string $email): self
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
    public function setName(string $name): void
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
        if (!$this->orders->contains($orders))
        {
            $this->orders[] = $orders;
            $orders->setClient($this);
        }

        return $this;
    }

    public function removeOrders(Order $orders): void
    {
        if ($this->orders->removeElement($orders))
        {
            // set the owning side to null (unless already changed)
            if ($orders->getClient() === $this)
            {
                $orders->setClient(null);
            }
        }
    }

    public function __toString(): string
    {
        return $this->email . ' ' . $this->telephone;
    }
}
