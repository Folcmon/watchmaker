<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    use \Gedmo\Timestampable\Traits\TimestampableEntity; 
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=RealisedService::class, mappedBy="client")
     */
    private $realisedServices;

    public function __construct()
    {
        $this->realisedServices = new ArrayCollection();
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
     * @return Collection|RealisedService[]
     */
    public function getRealisedServices(): Collection
    {
        return $this->realisedServices;
    }

    public function addRealisedService(RealisedService $realisedService): self
    {
        if (!$this->realisedServices->contains($realisedService)) {
            $this->realisedServices[] = $realisedService;
            $realisedService->setClient($this);
        }

        return $this;
    }

    public function removeRealisedService(RealisedService $realisedService): self
    {
        if ($this->realisedServices->removeElement($realisedService)) {
            // set the owning side to null (unless already changed)
            if ($realisedService->getClient() === $this) {
                $realisedService->setClient(null);
            }
        }

        return $this;
    }
    
    public function __toString() {
        return $this->email.' '.$this->telephone;
    }
}
