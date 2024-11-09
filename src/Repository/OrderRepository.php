<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @throws Exception
     */
    public function getCountByYearGroupByMonth(string $year): array
    {
        // SELECT COUNT(*) as count, MONTH(created_at) as month FROM order WHERE YEAR(created_at) = 2021 GROUP BY month ORDER BY month ASC example using raw sql
        $sql = "SELECT COUNT(*) as counter, MONTH(created_at) as month FROM orders WHERE YEAR(created_at) = :year GROUP BY month ORDER BY month ASC";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery(['year' => $year]);
        return $result->fetchAllAssociative();
    }

    /**
     * @throws Exception
     */
    public function getValueByYearGroupByMonth(string $year): array
    {
        $qb = $this->createQueryBuilder('o');
        $qb->addSelect('MONTH(o.createdAt) as month')
            ->andWhere('YEAR(o.createdAt) = :year')
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->setParameter('year', $year);
        $result = $qb->getQuery()->getResult();
        $returnResult = [];
        foreach ($result as $item) {
            $returnResult[] = [
                'counter' => (float)(number_format($item[0]->getTotalPrice() / 100, 2)),
                'month' => $item['month']
            ];
        }
        //it should return an array of associative arrays [{value: 1/100, month: 1}, {value: 2, month: 2/100}, ...]
        // dd($returnResult);
        return $returnResult;
    }

    // /**
    //  * @return Order[] Returns an array of Order objects
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
    public function findOneBySomeField($value): ?Order
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
