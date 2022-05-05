<?php

namespace Pidia\Apps\Demo\Repository;

use Doctrine\ORM\QueryBuilder;
use Pidia\Apps\Demo\Entity\Rendimiento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Security\Security;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method Rendimiento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rendimiento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rendimiento[]    findAll()
 * @method Rendimiento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RendimientoRepository extends ServiceEntityRepository implements BaseRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Rendimiento::class);
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
        $queryBuilder = $this->createQueryBuilder('rendimiento')
            ->select(['rendimiento', 'config'])
            ->join('rendimiento.config', 'config');

        $this->security->configQuery($queryBuilder, true);

        return $queryBuilder;
    }
}
