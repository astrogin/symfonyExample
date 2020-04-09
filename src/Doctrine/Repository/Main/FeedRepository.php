<?php

namespace App\Doctrine\Repository\Main;

use App\Doctrine\Entity\Main\Feed;
use App\Doctrine\Hydrators\Mysql\ColumnHydrator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Feed|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feed|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feed[]    findAll()
 * @method Feed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feed::class);
    }

    public function getSubmissionFeedIdsByStatus(string $status)
    {
        $this->getEntityManager()->getConfiguration()
            ->addCustomHydrationMode('COLUMN_HYDRATOR', ColumnHydrator::class);

        return $this->createQueryBuilder('f')
            ->select('f.submission_id')
            ->where('f.status = :status')
            ->setParameter('status', $status)
            ->getQuery()->getResult('COLUMN_HYDRATOR');
    }

    // /**
    //  * @return Feed[] Returns an array of Feed objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Feed
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
