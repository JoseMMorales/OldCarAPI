<?php

namespace App\Entity;

use App\Repository\CarsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarsRepository::class)
 */
class Cars
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="integer")
     */
    private $km;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $short_description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $long_description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=models::class, inversedBy="car")
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $main_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $second_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $third_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fourth_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fifth_image;

    /**
     * @ORM\ManyToOne(targetEntity=users::class, inversedBy="cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="favourite")
     */
    private $favourite;

    public function __construct()
    {
        $this->favourite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->long_description;
    }

    public function setLongDescription(string $long_description): self
    {
        $this->long_description = $long_description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getModel(): ?models
    {
        return $this->model;
    }

    public function setModel(?models $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getMainImage(): ?string
    {
        return $this->main_image;
    }

    public function setMainImage(string $main_image): self
    {
        $this->main_image = $main_image;

        return $this;
    }

    public function getSecondImage(): ?string
    {
        return $this->second_image;
    }

    public function setSecondImage(?string $second_image): self
    {
        $this->second_image = $second_image;

        return $this;
    }

    public function getThirdImage(): ?string
    {
        return $this->third_image;
    }

    public function setThirdImage(?string $third_image): self
    {
        $this->third_image = $third_image;

        return $this;
    }

    public function getFourthImage(): ?string
    {
        return $this->fourth_image;
    }

    public function setFourthImage(?string $fourth_image): self
    {
        $this->fourth_image = $fourth_image;

        return $this;
    }

    public function getFifthImage(): ?string
    {
        return $this->fifth_image;
    }

    public function setFifthImage(?string $fifth_image): self
    {
        $this->fifth_image = $fifth_image;

        return $this;
    }

    public function getUser(): ?users
    {
        return $this->user;
    }

    public function setUser(?users $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getFavourite(): Collection
    {
        return $this->favourite;
    }

    public function addFavourite(Users $favourite): self
    {
        if (!$this->favourite->contains($favourite)) {
            $this->favourite[] = $favourite;
            $favourite->addFavourite($this);
        }

        return $this;
    }

    public function removeFavourite(Users $favourite): self
    {
        if ($this->favourite->removeElement($favourite)) {
            $favourite->removeFavourite($this);
        }

        return $this;
    }
}
