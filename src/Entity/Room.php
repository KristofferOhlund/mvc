<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity; // krävs för att sätta attribut till unikt


#[ORM\Entity(repositoryClass: RoomRepository::class)]
#[UniqueEntity('name')] // sätter name attribut till ett unikt fält
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique:true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $background = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $weapons = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $foods = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $items = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(string $background): static
    {
        $this->background = $background;

        return $this;
    }

    public function getWeapons(): ?array
    {
        return $this->weapons;
    }

    public function setWeapons(?array $weapons): static
    {
        $this->weapons = $weapons;

        return $this;
    }

    public function getFoods(): ?array
    {
        return $this->foods;
    }

    public function setFoods(?array $foods): static
    {
        $this->foods = $foods;

        return $this;
    }

    public function getItems(): ?array
    {
        return $this->items;
    }

    public function setItems(?array $items): static
    {
        $this->items = $items;

        return $this;
    }
}
