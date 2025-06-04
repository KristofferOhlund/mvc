<?php

namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity; // krävs för att sätta attribut till unikt

#[ORM\Entity(repositoryClass: FoodRepository::class)]
#[UniqueEntity('name')] // sätter name attribut till ett unikt fält
class Food
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $icon = null;

    #[ORM\Column(length: 255, unique:true)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $healingValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getHealingValue(): ?int
    {
        return $this->healingValue;
    }

    public function setHealingValue(int $healingValue): static
    {
        $this->healingValue = $healingValue;

        return $this;
    }
}
