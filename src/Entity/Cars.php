<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cars
 *
 * @ORM\Table(name="cars", indexes={@ORM\Index(name="cars_brands", columns={"model_id"}), @ORM\Index(name="cars_sellers", columns={"id"})})
 * @ORM\Entity
 */
class Cars
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
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var int
     *
     * @ORM\Column(name="car_year", type="integer", nullable=false)
     */
    private $carYear;

    /**
     * @var int|null
     *
     * @ORM\Column(name="km", type="integer", nullable=true)
     */
    private $km;

    /**
     * @var string|null
     *
     * @ORM\Column(name="short_description", type="string", length=80, nullable=true)
     */
    private $shortDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="long_description", type="string", length=300, nullable=true)
     */
    private $longDescription;

    /**
     * @var int
     *
     * @ORM\Column(name="car_price", type="integer", nullable=false)
     */
    private $carPrice;

    /**
     * @var string|null
     *
     * @ORM\Column(name="main_image", type="string", length=255, nullable=true)
     */
    private $mainImage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="second_image", type="string", length=255, nullable=true)
     */
    private $secondImage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="third_image", type="string", length=255, nullable=true)
     */
    private $thirdImage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fourth_image", type="string", length=255, nullable=true)
     */
    private $fourthImage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fifth_image", type="string", length=255, nullable=true)
     */
    private $fifthImage;

    /**
     * @var \Models
     *
     * @ORM\ManyToOne(targetEntity="Models")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     * })
     */
    private $model;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, inversedBy="cars")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUsers(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUsers(Users $user): self
    {
        $this->users->removeElement($user);

        return $this;
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

    public function getCarYear(): ?int
    {
        return $this->carYear;
    }

    public function setCarYear(int $carYear): self
    {
        $this->carYear = $carYear;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(?int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function setLongDescription(?string $longDescription): self
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    public function getCarPrice(): ?int
    {
        return $this->carPrice;
    }

    public function setCarPrice(int $carPrice): self
    {
        $this->carPrice = $carPrice;

        return $this;
    }

    public function getMainImage(): ?string
    {
        return $this->mainImage;
    }

    public function setMainImage(?string $mainImage): self
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    public function getSecondImage(): ?string
    {
        return $this->secondImage;
    }

    public function setSecondImage(?string $secondImage): self
    {
        $this->secondImage = $secondImage;

        return $this;
    }

    public function getThirdImage(): ?string
    {
        return $this->thirdImage;
    }

    public function setThirdImage(?string $thirdImage): self
    {
        $this->thirdImage = $thirdImage;

        return $this;
    }

    public function getFourthImage(): ?string
    {
        return $this->fourthImage;
    }

    public function setFourthImage(?string $fourthImage): self
    {
        $this->fourthImage = $fourthImage;

        return $this;
    }

    public function getFifthImage(): ?string
    {
        return $this->fifthImage;
    }

    public function setFifthImage(?string $fifthImage): self
    {
        $this->fifthImage = $fifthImage;

        return $this;
    }

    public function getModel(): ?Models
    {
        return $this->model;
    }

    public function setModel(?Models $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}
