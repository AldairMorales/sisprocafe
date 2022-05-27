<?php

namespace Pidia\Apps\Demo\Repository;

use Doctrine\ORM\QueryBuilder;
use Pidia\Apps\Demo\Entity\DetallePeriodo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Security\Security;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method DetallePeriodo|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetallePeriodo|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetallePeriodo[]    findAll()
 * @method DetallePeriodo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetallePeriodoRepository extends ServiceEntityRepository implements BaseRepository
{
    public function __construct(ManagerRegistry $registry, private Security $security)
    {
        parent::__construct($registry, DetallePeriodo::class);
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
        $queryBuilder = $this->createQueryBuilder('detalle_periodo')
            ->select(['detalle_periodo', 'config'])
            ->join('detalle_periodo.config', 'config');

        $this->security->configQuery($queryBuilder, true);

        return $queryBuilder;
    }
}
