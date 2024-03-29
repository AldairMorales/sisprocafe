<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Repository;

use Doctrine\ORM\QueryBuilder;
use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Util\Paginator;
use Pidia\Apps\Demo\Security\Security;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Entity\AnalisisFisico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method AnalisisFisico|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnalisisFisico|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnalisisFisico[]    findAll()
 * @method AnalisisFisico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnalisisFisicoRepository extends ServiceEntityRepository implements BaseRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, AnalisisFisico::class);
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
        $queryBuilder = $this->createQueryBuilder('analisisFisico')
            ->select(['analisisFisico', 'config'])
            ->join('analisisFisico.config', 'config');

        $this->security->configQuery($queryBuilder, true);

        //Paginator::queryTexts($queryBuilder, $params, ['analisisFisico.nombre']);

        return $queryBuilder;
    }
    /**
     * @throws NonUniqueResultException
     */
    public function buscarFisico(int $idacopio): ?AnalisisFisico
    {
        $query = $this->createQueryBuilder('fisico')
            ->where('fisico.acopio = :acopio')
            ->setParameter('acopio', $idacopio)
            ->setMaxResults(1);
        return $query->getQuery()->getOneOrNullResult();
    }
}
