<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavoriteRepository::class)
 */
class Favorite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $picture;

    /**
     * @ORM\ManyToOne(targetEntity=CyclingShirt::class, inversedBy="favorites")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?CyclingShirt $cyclingShirt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCyclingShirt(): ?CyclingShirt
    {
        return $this->cyclingShirt;
    }

    public function setCyclingShirt(?CyclingShirt $cyclingShirt): self
    {
        $this->cyclingShirt = $cyclingShirt;

        return $this;
    }
}
