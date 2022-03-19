<?php

namespace App\Repository;

use App\Entity\VKAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VKAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method VKAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method VKAccount[]    findAll()
 * @method VKAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VKAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VKAccount::class);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @return VKAccount[]
     */
    public function findLoggedIn(): array
    {
        $query = $this->createQueryBuilder('v')
            ->andWhere('v.accessToken IS NOT NULL')
            ->andWhere('v.enabled = 1')
            ->getQuery()
        ;

        return $query->getResult() ?? [];
    }

    /**
     * @return VKAccount[]
     */
    public function findNotLoggedIn(): array
    {
        $query = $this->createQueryBuilder('v')
            ->andWhere('v.accessToken IS NULL')
            ->andWhere('v.enabled = 1')
            ->getQuery()
        ;

        return $query->getResult() ?? [];
    }

    // /**
    //  * @return VKAccount[] Returns an array of VKAccount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VKAccount
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
