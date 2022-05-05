<?php

namespace Pidia\Apps\Demo\Repository;

use Doctrine\ORM\QueryBuilder;
use Pidia\Apps\Demo\Entity\PrecioAcopio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Security\Security;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method PrecioAcopio|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrecioAcopio|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrecioAcopio[]    findAll()
 * @method PrecioAcopio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrecioAcopioRepository extends ServiceEntityRepository implements BaseRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, PrecioAcopio::class);
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
        $queryBuilder = $this->createQueryBuilder('precioAcopio')
            ->select(['precioAcopio', 'config'])
            ->join('precioAcopio.config', 'config');

        $this->security->configQuery($queryBuilder, true);

        return $queryBuilder;
    }
}
