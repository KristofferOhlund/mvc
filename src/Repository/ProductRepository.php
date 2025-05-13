<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 * 
 * Alla entiteter får en EntityRepository, detta för att kunna använda find, findall m.m
 * Önskar vi ytterligare queries så är det i vår EntityRepository vi definerar nya metoder.
 * Dessa metoder kan använda Doctrine QueryBuilder (DQL) eller ren sql
 * 
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

       /**
        * Find all producs having a value above the specified one.
        * DQL 'Doctrine Query Language'
        * @return Product[] Returns an array of Product objects
        *
        */
       public function findByMinimumValue($value): array
       {
           return $this->createQueryBuilder('p')
               ->andWhere('p.value >= :value')
               // För att undvika SQL injections anävnder vi setParameter
               // Doctrine avgör automatiskt typen men den kan även settas explicit
               // ->setParameter('min', $value, ParameterType::INTEGER)
               ->setParameter('value', $value)
               ->orderBy('p.value', 'ASC')
               // Gör om QueryBuilder instansen till ett objekt
               ->getQuery()
               // Execute Query
               ->getResult()
           ;
       }

        /**
         * Find all producs having a value above the specified one with SQL.
         * SQL
         * @return [][] Returns an array of arrays (i.e. a raw data set)
         */
        public function findByMinimumValue2($value): array
        {
            $conn = $this->getEntityManager()->getConnection();

            $sql = '
                SELECT * FROM product AS p
                WHERE p.value >= :value
                ORDER BY p.value ASC
            ';

            $resultSet = $conn->executeQuery($sql, ['value' => $value]);

            return $resultSet->fetchAllAssociative();
        }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
