<?php

namespace App\Entity;

use App\Repository\BrandsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BrandsRepository::class)
 */
class Brands
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
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity=Models::class, mappedBy="brands", orphanRemoval=true)
     */
    private $models;

    public function __construct()
    {
        $this->models = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|Models[]
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(Models $model): self
    {
        if (!$this->models->contains($model)) {
            $this->models[] = $model;
            $model->setBrands($this);
        }

        return $this;
    }

    public function removeModel(Models $model): self
    {
        if ($this->models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getBrands() === $this) {
                $model->setBrands(null);
            }
        }

        return $this;
    }
}
