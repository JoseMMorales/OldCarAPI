<?php

namespace App\Repository;

use App\Entity\Cars;
use App\Entity\Brands;
use App\Entity\Models;
use App\Entity\Users;
use Doctrine\ORM\EntityRepository;

class SearchRepository extends EntityRepository
{
  public function searchCars() {

    $imageURL = "http://localhost:8000/img/";
    
    return $this->getEntityManager()
            ->createQuery(
              "SELECT 
                c.carId as id,
                c.carYear as year, 
                c.km as km,
                c.shortDescription as description,
                c.carPrice as price,
                CONCAT('$imageURL' , c.mainImage) as image,
                m.modelName as model, 
                b.brandName as brand,
                u.userType as seller
              FROM App:Cars c 
              JOIN App:Users u WITH c.user = u.userId
              JOIN App:Models m WITH c.model = m.id
              JOIN App:Brands b WITH m.brand = b.id
              WHERE b.brandName = 'Austin'")

            ->getResult();
  }
}