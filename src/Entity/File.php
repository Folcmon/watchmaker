<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use DateTimeInterface;

#[ORM\Entity(repositoryClass: "App\Repository\FileRepository")]
#[ORM\HasLifecycleCallbacks]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "uuid", unique: true)]
    private Uuid $uuid;

    #[ORM\Column(type: "string", length: 255)]
    private string $path;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $originalFilename = null;

    #[ORM\Column(type: "datetime")]
    private DateTimeInterface $createdAt;

    #[ORM\Column]
    private ?int $usedTimes = null;

    public function __construct(Uuid $uuid, string $originalFilename, string $extension)
    {
        $this->uuid = $uuid;
        $this->originalFilename = $originalFilename;
        $this->createdAt = new \DateTime();

        // Tworzymy dynamiczną ścieżkę katalogu na podstawie daty
        $this->path = sprintf('%s/%s/%s/%s.%s',
            $this->createdAt->format('Y'),
            $this->createdAt->format('m'),
            $this->createdAt->format('d'),
            $this->uuid->toRfc4122(),
            $extension
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getOriginalFilename(): ?string
    {
        return $this->originalFilename;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    #[ORM\PostRemove]
    public function removeFile(): void
    {
        $filePath = __DIR__ . '/../../public/uploads/' . $this->path;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function getUsedTimes(): ?int
    {
        return $this->usedTimes;
    }

    public function setUsedTimes(int $usedTimes): static
    {
        $this->usedTimes = $usedTimes;

        return $this;
    }
}
