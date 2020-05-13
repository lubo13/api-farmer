<?php

namespace App\Repository;

use App\Entity\ContractAsset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContractAsset|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractAsset|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractAsset[]    findAll()
 * @method ContractAsset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractAssetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractAsset::class);
    }

    // /**
    //  * @return ContractAsset[] Returns an array of ContractAsset objects
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
    public function findOneBySomeField($value): ?ContractAsset
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
