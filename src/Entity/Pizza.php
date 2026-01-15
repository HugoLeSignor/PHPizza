<?php

namespace App\Entity;

use App\Repository\PizzaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(targetEntity: DoughType::class, inversedBy: 'pizzas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DoughType $doughType = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'pizzas')]
    #[ORM\JoinTable(name: 'pizza_ingredient')]
    private Collection $ingredients;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'pizzas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->ingredients = new ArrayCollection();
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

    public function getDoughType(): ?DoughType
    {
        return $this->doughType;
    }

    public function setDoughType(?DoughType $doughType): self
    {
        $this->doughType = $doughType;
        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);
        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }
}
