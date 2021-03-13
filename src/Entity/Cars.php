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


}
