<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\DocumentTypeEnum;
use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
#[ApiResource]
class Document
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'document')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $associated_order = null;

    #[ORM\Column(enumType: DocumentTypeEnum::class)]
    private ?DocumentTypeEnum $document_type = null;

    #[ORM\Column(type: 'json')]
    private array $document_data = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssociatedOrder(): ?Order
    {
        return $this->associated_order;
    }

    public function setAssociatedOrder(?Order $associated_order): static
    {
        $this->associated_order = $associated_order;

        return $this;
    }

    public function getDocumentType(): ?DocumentTypeEnum
    {
        return $this->document_type;
    }

    public function setDocumentType(DocumentTypeEnum $document_type): static
    {
        $this->document_type = $document_type;

        return $this;
    }

    public function getDocumentData(): array
    {
        return $this->document_data;
    }

    public function setDocumentData(array $document_data): static
    {
        $this->document_data = $document_data;

        return $this;
    }
}
