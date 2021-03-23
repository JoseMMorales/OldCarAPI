<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Brands
 *
 * @ORM\Table(name="brands")
 * @ORM\Entity
 */
class Brands
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="brand_name", type="string", length=32, nullable=false)
     */
    private $brandName;

    /**
     * @ORM\OneToMany(targetEntity=Models::class, mappedBy="brand")
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

    public function getModels(): ?Collection
    {
        return $this->models;
    }

    public function getBrandName(): ?string
    {
        return $this->brandName;
    }

    public function setBrandName(string $brandName): self
    {
        $this->brandName = $brandName;

        return $this;
    }


}
