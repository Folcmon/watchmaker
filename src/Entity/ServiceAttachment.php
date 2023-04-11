<?php

namespace App\Entity;

use App\Repository\ServiceAttachementRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ServiceAttachementRepository::class)]
class ServiceAttachment
{
    const SERVICE_ATTACHMENT_STORE_FOLDER = 'service_attachment';
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $path;

    #[ORM\ManyToOne(targetEntity: Order::class, cascade: ['persist'], inversedBy: 'serviceAttachments')]
    private ?Order $service;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getService(): ?Order
    {
        return $this->service;
    }

    public function setService(?Order $service): self
    {
        $this->service = $service;

        return $this;
    }
}
