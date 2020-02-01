<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    /**
     * @return Booking[] Returns an array of Booking objects
     */
    public function findMyBookings($value)
    {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->leftJoin(Meal::class, 'm', 'WITH', 'b.meal = m.id')
            ->andWhere('b.traveler = :val')
            ->setParameter('val', $value)
            ->orderBy('m.dateMeal', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Booking[] Returns an array of Booking objects
     */
    public function findMyTravelersBookings($value)
    {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->leftJoin(Meal::class, 'm', 'WITH', 'b.meal = m.id')
            ->andWhere('m.host = :val')
            ->setParameter('val', $value)
            ->orderBy('m.dateMeal', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findIfAlreadyBooked($value)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM booking b WHERE b.meal_id = :mealId';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['mealId' => $value]);

    // returns an array of arrays (i.e. a raw data set)
    return $stmt->fetchAll();
    }

    public function findIfAlreadyPaid($mealId, $travellerId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM booking b WHERE b.meal_id = :mealId and b.traveler_id = :travellerId';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'meal' => $mealId,
            'traveller' => $travellerId
            ]);

    // returns an array of arrays (i.e. a raw data set)
    return $stmt->fetchAll();
    }

    public function updateBookingAfterPayment($mealId, $travellerId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE booking SET is_payed = true WHERE meal_id = :mealId and traveler_id = :travellerId';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'mealId' => $mealId,
            'travellerId' => $travellerId
            ]);
    }

    // /**
    //  * @return Booking[] Returns an array of Booking objects
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
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByHost($value)
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.meal', 'm', 'WITH', 'm.host = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }
    */


}
