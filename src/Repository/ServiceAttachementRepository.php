<?php

namespace App\Repository;

use App\Entity\ServiceAttachment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ServiceAttachment|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceAttachment|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceAttachment[]    findAll()
 * @method ServiceAttachment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceAttachementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceAttachment::class);
    }

    // /**
    //  * @return ServiceAttachment[] Returns an array of ServiceAttachment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServiceAttachement
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
