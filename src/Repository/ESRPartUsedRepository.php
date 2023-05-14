<?php

namespace App\Repository;

use App\Entity\ESRPartUsed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ESRPartUsed>
 *
 * @method ESRPartUsed|null find($id, $lockMode = null, $lockVersion = null)
 * @method ESRPartUsed|null findOneBy(array $criteria, array $orderBy = null)
 * @method ESRPartUsed[]    findAll()
 * @method ESRPartUsed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ESRPartUsedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ESRPartUsed::class);
    }

    public function save(ESRPartUsed $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ESRPartUsed $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ESRPartUsed[] Returns an array of ESRPartUsed objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ESRPartUsed
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
