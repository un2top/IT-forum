<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
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

    public function add(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLatestPublished()
    {
        return $this->published($this->latest())
            ->getQuery()
            ->getResult();
    }

    private function published(QueryBuilder $qb = null)
    {
        return $this->getOnCreateQueryBuilder($qb)->andWhere('a.publishedAt IS NOT NULL');
    }

    private function latest(QueryBuilder $qb = null)
    {
        return $this->getOnCreateQueryBuilder($qb)->orderBy('a.publishedAt', 'DESC');
    }

    public function findPublished()
    {

        return $this->published()
            ->getQuery()
            ->getResult();
    }

    public function findLatest()
    {
        return $this->latest()
            ->getQuery()
            ->getResult();
    }

    /**
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    private function getOnCreateQueryBuilder(?QueryBuilder $qb): QueryBuilder
    {
        return $qb ?? $this->createQueryBuilder('a');;
    }


}
