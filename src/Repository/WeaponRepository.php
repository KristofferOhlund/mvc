<?php

namespace App\Repository;

use App\Entity\Weapon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Weapon>
 */
class WeaponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weapon::class);
    }

    //    /**
    //     * @return Weapon[] Returns an array of Weapon objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    /**
     * Query Weapon by name
     * @return Weapon|null
     */
    public function findWeaponByName(string $value): ?Weapon
    {
        return $this->createQueryBuilder('b')
            ->setParameter('val', $value)
            ->andWhere('b.name = :val')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
