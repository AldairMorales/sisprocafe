<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pidia\Apps\Demo\Entity\AnalisisSensorial;
use Pidia\Apps\Demo\Entity\Usuario;
use Doctrine\Persistence\ManagerRegistry;
use Pidia\Apps\Demo\Entity\SensorialUsuario;
use Pidia\Apps\Demo\Security\Security;
use Pidia\Apps\Demo\Util\Paginator;

/**
 * @method SensorialUsuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method SensorialUsuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method SensorialUsuario[]    findAll()
 * @method SensorialUsuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SensorialUsuarioRepository extends ServiceEntityRepository implements BaseRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, SensorialUsuario::class);
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
        $queryBuilder = $this->createQueryBuilder('sensorialUsuario')
            ->select(['sensorialUsuario', 'config'])
            ->join('sensorialUsuario.config', 'config');

        $this->security->configQuery($queryBuilder, true);

        return $queryBuilder;
    }
    /**
     * @throws NonUniqueResultException
     */
    public function buscarSensorialUsuario(AnalisisSensorial $sensorial, Usuario $usuario): ?SensorialUsuario
    {
        $query = $this->createQueryBuilder('s_u')
            ->where('s_u.analisisSensorial = :sensorial')
            ->andWhere('s_u.usuario = :usuario')
            ->setParameter('sensorial', $sensorial->getId())
            ->setParameter('usuario', $usuario->getId());
        return $query->getQuery()->getOneOrNullResult();
    }

    public function promedioAnalisisSensorial(AnalisisSensorial $analisisSensorial): ?array
    {
        $query = $this->createQueryBuilder('s_u')
            ->select([
                'AVG(s_u.fragrancia) as fragrancia',
                'AVG(s_u.sabor) as sabor',
                'AVG(s_u.saborResidual) as saborResidual',
                'AVG(s_u.acidez) as acidez',
                'AVG(s_u.cuerpo) as cuerpo',
                'AVG(s_u.balance) as balance',
                'AVG(s_u.puntajeCatador) as puntajeCatador'
            ])
            ->where('s_u.analisisSensorial = :sensorial')
            ->setParameter('sensorial', $analisisSensorial->getId())
            ->setMaxResults(1);
        return $query->getQuery()->getOneOrNullResult();
    }
}
