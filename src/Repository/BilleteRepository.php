<?php

namespace App\Repository;

use App\Entity\Billete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Billete>
 *
 * @method Billete|null find($id, $lockMode = null, $lockVersion = null)
 * @method Billete|null findOneBy(array $criteria, array $orderBy = null)
 * @method Billete[]    findAll()
 * @method Billete[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilleteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Billete::class);
    }

//    /**
//     * @return Billete[] Returns an array of Billete objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Billete
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
