<?php

namespace Pidia\Apps\Demo\Repository;

use Doctrine\ORM\QueryBuilder;
use Pidia\Apps\Demo\Entity\Traslado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Security\Security;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method Traslado|null find($id, $lockMode = null, $lockVersion = null)
 * @method Traslado|null findOneBy(array $criteria, array $orderBy = null)
 * @method Traslado[]    findAll()
 * @method Traslado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrasladoRepository extends ServiceEntityRepository implements BaseRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Traslado::class);
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
        $queryBuilder = $this->createQueryBuilder('traslado')
            ->select(['traslado', 'config'])
            ->join('traslado.config', 'config');

        $this->security->configQuery($queryBuilder, true);

        Paginator::queryTexts($queryBuilder, $params, ['traslado.fechaSalida', 'traslado.numeroGuia']);

        return $queryBuilder;
    }


    public function ultimo_traslado_Id(): ?array
    {
        return $this->createQueryBuilder('traslado')
            ->select('traslado.numeroGuia')
            ->orderBy('traslado.id', 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getResult();
    }
}
