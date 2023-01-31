<?php

namespace App\Entity;

use App\Repository\ServiceAttachementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceAttachementRepository::class)]
class ServiceAttachment
{
    const SERVICE_ATTACHMENT_STORE_FOLDER = 'service_attachment';
    use \Gedmo\Timestampable\Traits\TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $path;

    #[ORM\ManyToOne(targetEntity: RealisedService::class, inversedBy: 'serviceAttachments')]
    private $service;

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

    public function getService(): ?RealisedService
    {
        return $this->service;
    }

    public function setService(?RealisedService $service): self
    {
        $this->service = $service;

        return $this;
    }
}