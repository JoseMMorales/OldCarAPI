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
    private $brand_name;

    /**
     * @ORM\OneToMany(targetEntity=Models::class, mappedBy="brand_name", orphanRemoval=true)
     */
    private $model_name;

    public function __construct()
    {
        $this->model_name = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrandName(): ?string
    {
        return $this->brand_name;
    }

    public function setBrandName(string $brand_name): self
    {
        $this->brand_name = $brand_name;

        return $this;
    }

    /**
     * @return Collection|Models[]
     */
    public function getModelName(): Collection
    {
        return $this->model_name;
    }

    public function addModelName(Models $modelName): self
    {
        if (!$this->model_name->contains($modelName)) {
            $this->model_name[] = $modelName;
            $modelName->setBrandName($this);
        }

        return $this;
    }

    public function removeModelName(Models $modelName): self
    {
        if ($this->model_name->removeElement($modelName)) {
            // set the owning side to null (unless already changed)
            if ($modelName->getBrandName() === $this) {
                $modelName->setBrandName(null);
            }
        }

        return $this;
    }
}
