<?php

namespace App\Repository;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cars;

/**
 * @method Cars|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cars|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cars[]    findAll()
 * @method Cars[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarsRepository extends ServiceEntityRepository
{
    private $params;

    public function __construct(
        ManagerRegistry $registry, 
        ParameterBagInterface $params)
    {
        parent::__construct($registry, Cars::class);
        $this->params= $params;
    }

    public function searchCars($brand, $model, $seller, $year, $km, $price)
    {
        $imageURL = $this->params->get('photos_cars_URL');

        $yearRangeLess = $year - 5;
        $yearRangeMore = $year + 5;
        $kmRangeLess = $km - 5000;
        $kmRangeMore = $km + 5000;
        $priceRangeLess = $price - 5000;
        $priceRangeMore = $price + 5000;

        $sql_where = "";

        if($brand !== 0) {
            $sql_where .=  "AND b.brandName = '$brand' ";
        }

        if($model !== 0) {
            $sql_where .= "AND m.modelName = '$model' ";
        }

        if($seller !== 0) {
            $sql_where .= "AND u.type = '$seller' ";
        }

        if($year !== 0) {
            $sql_where .= "AND c.carYear BETWEEN $yearRangeLess AND $yearRangeMore";
        }

        if($km !== 0) {
            $sql_where .= "AND c.km BETWEEN $kmRangeLess AND $kmRangeMore";
        }

        if($price !== 0) {
            $sql_where .= "AND c.carPrice BETWEEN $priceRangeLess AND $priceRangeMore";
        }

        if (!$brand && !$model && !$seller && !$year && !$km && !$price) {
            $sql_where .= "AND c.id in (63, 1, 36, 19, 65)";
        }

        $sql_where_amended = substr($sql_where, 3);

        $sql = "SELECT 
                    c.id as id,
                    c.carYear as year, 
                    c.km as km,
                    c.shortDescription as description,
                    c.carPrice as price,
                    CONCAT('$imageURL' , c.mainImage) as image,
                    m.modelName as model, 
                    b.brandName as brand,
                    u.type as seller
                FROM App:Cars c 
                JOIN App:Users u WITH c.user = u.id
                JOIN App:Models m WITH c.model = m.id
                JOIN App:Brands b WITH m.brand = b.id
                WHERE $sql_where_amended";

        return $this->getEntityManager()
                    ->createQuery($sql)
                    ->getResult();
    }

    public function detailsCars($id)
    {
        $imageURL = $this->params->get('photos_cars_URL');

        return $this->getEntityManager()
                    ->createQuery(
                        "SELECT 
                            c.id as id,
                            c.carYear as year, 
                            c.km as km,
                            c.shortDescription as description,
                            c.longDescription as sellerDescription,
                            c.carPrice as price,
                            m.modelName as model, 
                            b.brandName as brand,
                            CONCAT('$imageURL' , c.mainImage) as mainImage,
                            CONCAT('$imageURL' , c.secondImage) as secondImage,
                            CONCAT('$imageURL' , c.thirdImage) as thirdImage,
                            CONCAT('$imageURL' , c.fourthImage) as fourthImage,
                            CONCAT('$imageURL' , c.fifthImage) as fifthImage,
                            u.name as sellerName,
                            u.address as sellerAddress,
                            u.phone as sellerPhone,
                            u.email as sellerEmail,
                            u.type as seller
                        FROM App:Cars c 
                        JOIN App:Users u WITH c.user = u.id
                        JOIN App:Models m WITH c.model = m.id
                        JOIN App:Brands b WITH m.brand = b.id
                        WHERE c.id = '$id'")
                    ->getResult();
    }

    // /**
    //  * @return Cars[] Returns an array of Cars objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cars
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
