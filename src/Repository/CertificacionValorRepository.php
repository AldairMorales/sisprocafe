<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Entity\CertificacionValor;
use Pidia\Apps\Demo\Security\Security;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method CertificacionValor|null find($id, $lockMode = null, $lockVersion = null)
 * @method CertificacionValor|null findOneBy(array $criteria, array $orderBy = null)
 * @method CertificacionValor[]    findAll()
 * @method CertificacionValor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CertificacionValorRepository extends ServiceEntityRepository implements BaseRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, CertificacionValor::class);
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
        $queryBuilder = $this->createQueryBuilder('certificacionValor')
            ->select(['certificacionValor', 'config'])
            ->join('certificacionValor.config', 'config');

        $this->security->configQuery($queryBuilder, true);

        return $queryBuilder;
    }
}
