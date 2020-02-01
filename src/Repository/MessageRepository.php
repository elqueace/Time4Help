<?php

namespace App\Repository;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findAllMessages($user): array
    {
        return $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.receiver = :user')
            ->orWhere('m.sender = :user')
            ->setParameter('user', $user)
            ->orderBy('m.created_at', 'DESC')
            ->getQuery()
            ->getResult()
        ;    
    }

    /**
     * Retourne tous les messages entre 2 utilisateurs
     */
    public function findAllMessagesUsers($user, $other): array
    {
        // On met les messages en "lu" si derniers messages ne sont pas ceux de l'utilisateur courant
        $ur = $this->createQueryBuilder('message');
        $q = $ur->update('App\Entity\Message', 'm')
                ->set('m.status', "'lu'")
                ->where($this->createQueryBuilder('m')->expr()->andX(
                    $this->createQueryBuilder('m')->expr()->eq('m.receiver', ':user'),
                    $this->createQueryBuilder('m')->expr()->eq('m.sender', ':other')
                ))
                ->setParameter('user', $user)
                ->setParameter('other', $other)
                ->getQuery();
        $p = $q->execute();

        $qb = $this->createQueryBuilder('m')
            ->select('m')
            // Deux configurations possibles :
            // Soit l'utilisateur courant est receiver, soit il est sender
            ->where($this->createQueryBuilder('m')->expr()->andX(
                $this->createQueryBuilder('m')->expr()->eq('m.receiver', ':user'),
                $this->createQueryBuilder('m')->expr()->eq('m.sender', ':other')

            ))
            ->orWhere($this->createQueryBuilder('m')->expr()->andX(
                $this->createQueryBuilder('m')->expr()->eq('m.receiver', ':other'),
                $this->createQueryBuilder('m')->expr()->eq('m.sender', ':user')
            ))
            ->setParameter('user', $user)
            ->setParameter('other', $other)
            ->orderBy('m.created_at', 'ASC')
            ->getQuery()
            ->getResult();

        return $qb;
    }

    /**
     * Retourne tous les messages entre 2 utilisateurs
     */
    public function countMessageStatus($user, $status): array
    {
        $qb = $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->where('m.status = :status')
            ->andWhere('m.receiver = :user')
            ->setParameter('user', $user)
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult();

        return $qb;
    }


    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
