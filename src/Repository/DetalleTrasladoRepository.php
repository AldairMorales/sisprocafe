<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Entity\DetalleTraslado;
use Pidia\Apps\Demo\Security\Security;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method DetalleTraslado|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetalleTraslado|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetalleTraslado[]    findAll()
 * @method DetalleTraslado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetalleTrasladoRepository extends ServiceEntityRepository implements BaseRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, DetalleTraslado::class);
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
        $queryBuilder = $this->createQueryBuilder('detalleTraslado')
            ->select(['detalleTraslado', 'config'])
            ->join('detalleTraslado.config', 'config');

        $this->security->configQuery($queryBuilder, true);

        Paginator::queryTexts($queryBuilder, $params, ['detalleTraslado.peso', 'detalleTraslado.cantidad']);

        return $queryBuilder;
    }
}
