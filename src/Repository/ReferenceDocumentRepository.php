<?php

namespace App\Repository;

use App\Entity\ReferenceDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ReferenceDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReferenceDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReferenceDocument[]    findAll()
 * @method ReferenceDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferenceDocumentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ReferenceDocument::class);
    }

    // /**
    //  * @return ReferenceDocument[] Returns an array of ReferenceDocument objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReferenceDocument
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
