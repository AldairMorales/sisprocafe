<?php

namespace Pidia\Apps\Demo\Manager;

use Doctrine\ORM\EntityRepository;
use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Repository\BaseRepository;
use Pidia\Apps\Demo\Util\Paginator;

class AcopioManager extends BaseManager
{
    public function repositorio(): BaseRepository|EntityRepository
    {
        return $this->manager()->getRepository(Acopio::class);
    }

    public function listPaginated(array $queryValues, int $page): Paginator
    {
        $params = Paginator::params($queryValues, $page);
        $certificacionId = $queryValues['certificacionId'] ?? null;
        $fechaInicio = $queryValues['fechaInicio'] ?? null;
        $fechaFinal = $queryValues['fechaFinal'] ?? null;

        $params = array_merge($params, [
            'certificacionId' => $certificacionId,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal,
        ]);

        return $this->repositorio()->findLatest($params);
    }
}
