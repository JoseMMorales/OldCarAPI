<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchRepository")
 */
class Search
{
   public function getCars() {
      // etc
   }
}