<?php

namespace App\Repository;

use App\Entity\ContractRentAsset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContractRentAsset|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractRentAsset|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractRentAsset[]    findAll()
 * @method ContractRentAsset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractRentAssetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractRentAsset::class);
    }

    // /**
    //  * @return ContractRentAsset[] Returns an array of ContractRentAsset objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContractRentAsset
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
