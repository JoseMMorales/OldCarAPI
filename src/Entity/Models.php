<?php

namespace App\Entity;

use App\Repository\ModelsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $model;

    /**
     * @ORM\ManyToOne(targetEntity=brands::class, inversedBy="models")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brands;

    /**
     * @ORM\OneToMany(targetEntity=Cars::class, mappedBy="model")
     */
    private $car;

    public function __construct()
    {
        $this->car = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getBrands(): ?brands
    {
        return $this->brands;
    }

    public function setBrands(?brands $brands): self
    {
        $this->brands = $brands;

        return $this;
    }

    /**
     * @return Collection|Cars[]
     */
    public function getCar(): Collection
    {
        return $this->car;
    }

    public function addCar(Cars $car): self
    {
        if (!$this->car->contains($car)) {
            $this->car[] = $car;
            $car->setModel($this);
        }

        return $this;
    }

    public function removeCar(Cars $car): self
    {
        if ($this->car->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getModel() === $this) {
                $car->setModel(null);
            }
        }

        return $this;
    }
}
