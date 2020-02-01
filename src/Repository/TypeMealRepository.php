<?php

namespace App\Repository;

use App\Entity\TypeMeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeMeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeMeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeMeal[]    findAll()
 * @method TypeMeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeMealRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeMeal::class);
    }

    // /**
    //  * @return TypeMeal[] Returns an array of TypeMeal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeMeal
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
