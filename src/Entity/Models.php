<?php

namespace App\Entity;

use App\Repository\ModelsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModelsRepository::class)
 */
class Models
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $name_model;

    /**
     * @ORM\ManyToOne(targetEntity=brands::class, inversedBy="model_name")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameModel(): ?string
    {
        return $this->name_model;
    }

    public function setNameModel(string $name_model): self
    {
        $this->name_model = $name_model;

        return $this;
    }

    public function getBrandName(): ?brands
    {
        return $this->brand_name;
    }

    public function setBrandName(?brands $brand_name): self
    {
        $this->brand_name = $brand_name;

        return $this;
    }
}
