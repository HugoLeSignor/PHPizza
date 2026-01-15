<?php

namespace App\Entity;

use App\Repository\DoughTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoughTypeRepository::class)]
class DoughType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private string $name = '';

    #[ORM\OneToMany(targetEntity: Pizza::class, mappedBy: 'doughType')]
    private Collection $pizzas;

    public function __construct()
    {
        $this->pizzas = new ArrayCollection();
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

    /**
     * @return Collection<int, Pizza>
     */
    public function getPizzas(): Collection
    {
        return $this->pizzas;
    }

    public function addPizza(Pizza $pizza): self
    {
        if (!$this->pizzas->contains($pizza)) {
            $this->pizzas->add($pizza);
            $pizza->setDoughType($this);
        }

        return $this;
    }

    public function removePizza(Pizza $pizza): self
    {
        if ($this->pizzas->removeElement($pizza)) {
            if ($pizza->getDoughType() === $this) {
                $pizza->setDoughType(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
