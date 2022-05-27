<?php

namespace Pidia\Apps\Demo\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Entity\AnalisisFisico;
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
            ->select(['acopio', 'certificacion', 'config'])
            ->join('acopio.certificacion', 'certificacion')
            ->join('acopio.socio', 'socio')
            ->join('acopio.config', 'config');

        if (isset($params['certificacionId']) && '' !== $params['certificacionId']) {
            $queryBuilder
                ->andWhere('certificacion.id = :certificacionId')
                ->setParameter('certificacionId', $params['certificacionId']);
        }

        if (isset($params['fechaInicio']) && '' !== $params['fechaInicio']) {
            $queryBuilder
                ->andWhere('acopio.fecha >= :fechaInicio')
                ->setParameter('fechaInicio', $params['fechaInicio']);
        }

        if (isset($params['fechaFinal']) && '' !== $params['fechaFinal']) {
            $queryBuilder
                ->andWhere('acopio.fecha <= :fechaFinal')
                ->setParameter('fechaFinal', $params['fechaFinal']);
        }

        $this->security->configQuery($queryBuilder, true);

        Paginator::queryTexts($queryBuilder, $params, ['acopio.tikect', 'socio.nombres', 'socio.apellidoPaterno', 'socio.apellidoMaterno']);

        return $queryBuilder;
    }

    public function Acopio_Id(): array
    {
        return $this->createQueryBuilder('acopio')
            ->select(['acopio', 'config'])
            ->join('acopio.config', 'config')
            ->orderBy('acopio.id', 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function buscarFisico(Acopio $acopio): ?AnalisisFisico
    {
        $query = $this->createQueryBuilder('fisico')
            ->where('fisico.analisisFisico = :id')
            ->setParameter('id', $acopio->getId());

        return $query->getQuery()->getOneOrNullResult();
    }

    public function reportePorCliente(string $anterior): ?array
    {
        $query = $this->createQueryBuilder('acopio')
            ->where('acopio.fecha > :fechaAnterior')
            ->setParameter('fechaAnterior', $anterior);

        return $query->getQuery()->getResult();
    }
}
