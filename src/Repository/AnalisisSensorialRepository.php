<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Entity\AnalisisSensorial;
use Pidia\Apps\Demo\Security\Security;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method AnalisisSensorial|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnalisisSensorial|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnalisisSensorial[]    findAll()
 * @method AnalisisSensorial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnalisisSensorialRepository extends ServiceEntityRepository implements BaseRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, AnalisisSensorial::class);
        $this->security = $security;
    }

    public function findLatest(array $params): Paginator
    {
        $queryBuilder = $this->filterQuery($params);

        return Paginator::create($queryBuilder, $params);
    }

    public function filter(array $params, bool $inArray = true): array
    {
        $queryBuilder = $this->filterQuery($params);

        if (true === $inArray) {
            return $queryBuilder->getQuery()->getArrayResult();
        }

        return $queryBuilder->getQuery()->getResult();
    }

    private function filterQuery(array $params): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('analisisSensorial')
            ->select(['analisisSensorial', 'config'])
            ->join('analisisSensorial.config', 'config');

        $this->security->configQuery($queryBuilder, true);

        Paginator::queryTexts($queryBuilder, $params, ['analisisSensorial.periodo', 'analisisSensorial.certificacion']);

        return $queryBuilder;
    }
    public function AnalisisSensorial_Id(int $id): array
    {
        return $this->createQueryBuilder('analisisSensorial')
            ->select(['analisisSensorial', 'config'])
            ->join('analisisSensorial.config', 'config')
            ->where('analisisSensorial.id = :var')
            ->setParameter('var', $id)
            ->getQuery()
            ->getResult();
    }
}
