<?php

namespace App\Entity;

use App\Repository\PizzaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PizzaRepository::class)]
#[ORM\UniqueConstraint(name: 'unique_special_ingredient', fields: ['specialIngredient'])]
class Pizza
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name = '';

    #[ORM\Column(length: 255)]
    private string $specialIngredient = '';

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSpecialIngredient(): string
    {
        return $this->specialIngredient;
    }

    public function setSpecialIngredient(string $specialIngredient): self
    {
        $this->specialIngredient = $specialIngredient;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
