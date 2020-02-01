<?php

namespace App\Repository;

use App\Entity\Banish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Banish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Banish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Banish[]    findAll()
 * @method Banish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BanishRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Banish::class);
    }

    // /**
    //  * @return Banish[] Returns an array of Banish objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Banish
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
