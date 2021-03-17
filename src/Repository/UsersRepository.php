<?php

namespace App\Repository;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Users;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    private $params;

    public function __construct(
        ManagerRegistry $registry,
        ParameterBagInterface $params)
    {
        parent::__construct($registry, Users::class);
        $this->params= $params;
    }

    public function favouriteCars(int $id)
    {
        $imageURL = $this->params->get('photos_cars_URL');

        return $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select(
                        'user.id as idUser', 
                        'cars.id as idCar', 
                        'cars.carYear',
                        'cars.carPrice',
                        "CONCAT('$imageURL' , cars.mainImage) as image",
                        'model.modelName',
                        'brand.brandName')
                    ->from('App:Users', 'user')
                    ->join('user.cars','cars')
                    ->join('cars.model', 'model')
                    ->join('model.brand', 'brand')
                    ->where('user.id = :id')
                    ->setParameter('id' , $id)
                    ->getQuery()->getResult(); 
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return Users[] Returns an array of Users objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
