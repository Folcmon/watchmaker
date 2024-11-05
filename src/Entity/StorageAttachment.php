<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StorageAttachmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: StorageAttachmentRepository::class)]
#[ApiResource]
class StorageAttachment
{
    const STORAGE_ATTACHMENT_STORE_FOLDER = 'storage_attachment';
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\ManyToOne(inversedBy: 'storageAttachments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Storage $storage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getStorage(): ?Storage
    {
        return $this->storage;
    }

    public function setStorage(?Storage $storage): static
    {
        $this->storage = $storage;

        return $this;
    }
}
