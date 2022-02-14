<?php

namespace Pidia\Apps\Demo\Manager;

use Doctrine\ORM\EntityRepository;
use Pidia\Apps\Demo\Entity\EstadoSocio;
use Pidia\Apps\Demo\Repository\BaseRepository;

class EstadoSocioManager extends BaseManager
{
    public function repositorio(): BaseRepository|EntityRepository
    {
        return $this->manager()->getRepository(EstadoSocio::class);
    }
}