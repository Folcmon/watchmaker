<?php

namespace App\Entity;

use App\Repository\StorageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StorageRepository::class)
 */
class Storage
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
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $qunatity;

    /**
     * @ORM\Column(type="integer")
     */
    private $alarmQuantity;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQunatity(): ?int
    {
        return $this->qunatity;
    }

    public function setQunatity(int $qunatity): self
    {
        $this->qunatity = $qunatity;

        return $this;
    }

    public function getAlarmQuantity(): ?int
    {
        return $this->alarmQuantity;
    }

    public function setAlarmQuantity(int $alarmQuantity): self
    {
        $this->alarmQuantity = $alarmQuantity;

        return $this;
    }
}
