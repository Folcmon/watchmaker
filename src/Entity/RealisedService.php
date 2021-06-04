<?php

namespace App\Entity;

use App\Repository\RealisedServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RealisedServiceRepository::class)
 */
class RealisedService
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
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="realisedServices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=ServiceAttachment::class, mappedBy="service")
     */
    private Collection|array $serviceAttachments;

    public function __construct()
    {
        $this->serviceAttachments = new ArrayCollection();
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
     * @return Collection|ServiceAttachment[]
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
}
