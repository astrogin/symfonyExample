<?php

namespace App\Doctrine\Repository\Main\Products;

use App\Doctrine\Entity\Main\Products\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findDuplicatesByTextId(array $textIds)
    {
        $sql = 'SELECT p.text_id FROM App\Doctrine\Entity\Main\Products\Product p WHERE p.text_id IN (:text_ids)';
        $query = $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('text_ids', $textIds);

        $duplicates = $query->getResult();
        $duplicateTextIds = [];

        foreach ($duplicates as $duplicate) {
            $duplicateTextIds[] = $duplicate['text_id'];
        }

        return $duplicateTextIds;

    }
    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
