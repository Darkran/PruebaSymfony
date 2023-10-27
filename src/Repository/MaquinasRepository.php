<?php

namespace App\Repository;

use App\Entity\Maquinas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Maquinas>
 *
 * @method Maquinas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Maquinas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Maquinas[]    findAll()
 * @method Maquinas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaquinasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Maquinas::class);
    }

//    /**
//     * @return Maquinas[] Returns an array of Maquinas objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Maquinas
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
