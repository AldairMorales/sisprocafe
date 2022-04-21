<?php

namespace Pidia\Apps\Demo\Repository;

use Doctrine\ORM\QueryBuilder;
use Pidia\Apps\Demo\Entity\Acopio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Security\Security;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method Acopio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Acopio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Acopio[]    findAll()
 * @method Acopio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcopioRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Acopio::class);
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
        $queryBuilder = $this->createQueryBuilder('acopio')
            ->select(['acopio', 'config'])
            ->join('acopio.config', 'config');

        $this->security->configQuery($queryBuilder, true);

        Paginator::queryTexts($queryBuilder, $params, ['acopio.tara']);

        return $queryBuilder;
    }
    public function Acopio_Id(): array
    {
        return $this->createQueryBuilder('acopio')
            ->select(['acopio', 'config'])
            ->join('acopio.config', 'config')
            ->orderBy('acopio.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
