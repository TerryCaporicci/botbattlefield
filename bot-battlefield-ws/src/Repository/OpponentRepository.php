<?php

namespace App\Repository;

use App\Entity\Opponent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Opponent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opponent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opponent[]    findAll()
 * @method Opponent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpponentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Opponent::class);
    }

    // /**
    //  * @return Opponent[] Returns an array of Opponent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Opponent
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
