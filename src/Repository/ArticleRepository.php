<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findLatestPublished()
    {
        return $this->published($this->latest())
            ->leftJoin('a.comments', 'c')
            ->addSelect('c')
            ->leftJoin('a.tags', 't')
            ->addSelect('t')
            ->getQuery()
            ->getResult();
    }

    public function findAllPublishedLastWeek()
    {
        return $this->published($this->latest())
            ->andWhere('a.publishedAt >= :week_ago')
            ->setParameter('week_ago', new \DateTime('-1 week'))
            ->getQuery()
            ->getResult();
    }

    public function findAllPublishedFromInterval(string $dateFrom, string $dateTo)
    {
        return $this->published($this->latest())
            ->andWhere('a.publishedAt >= :dateFrom AND a.publishedAt <= :dateTo ')
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->getQuery()
            ->getResult();
    }

    public function findAllCreatedFromInterval(string $dateFrom, string $dateTo)
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->andWhere('a.createdAt >= :dateFrom AND a.createdAt<= :dateTo')
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findLatest()
    {
        return $this->latest()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findPublished()
    {
        return $this->published()
            ->getQuery()
            ->getResult();
    }

    public function findAllWithSearchQuery(?string $search)
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->innerJoin('a.author', 'u')
            ->addSelect('u');
        if ($search) {
            $qb
                ->andWhere('u.firstName LIKE :search OR a.title LIKE :search OR a.description LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }
        return $qb
            ->orderBy('a.publishedAt', 'DESC');
    }

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    private function published(QueryBuilder $qb = null)
    {
        return $this->getOrCreateQueryBuilder($qb)->andWhere('a.publishedAt IS NOT NULL');
    }

    public function latest(QueryBuilder $qb = null)
    {
        return $this->getOrCreateQueryBuilder($qb)->orderBy('a.publishedAt', 'DESC');
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $qb = null): QueryBuilder
    {
        return $qb ?? $this->createQueryBuilder('a');
    }
}
