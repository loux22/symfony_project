<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findAllMessageOnGroupe($groupe)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.groupe = :groupe')
            ->setParameter('groupe', $groupe)
            ->orderBy('m.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findLastMessageOnGroupe($groupe)
    {
        
        return $this->createQueryBuilder('m')
            ->Where('m.groupe = :groupe')
            ->setParameter('groupe', $groupe)
            ->setMaxResults(1)
            ->orderBy('m.date', 'DESC')
            ->getQuery()
            ->getSingleResult();
            
            
    }

    // $listAdverts = $repository->findByAuthor('groupe');

    // for ($i=0; $i = null ; $i++) { 
            //     $advert = $repository->findOneBy(array('m.groupe' => '$i'));
            // }


    // return $this->createQueryBuilder-> findBy(
    //     array('m.groupe' => 'groupe'),
    //     array('date' => 'desc' ),
    //     3,
    //     0);

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
