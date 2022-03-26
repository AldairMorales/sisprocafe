<?php

namespace Pidia\Apps\Demo\Manager;

use Doctrine\ORM\EntityRepository;
use Pidia\Apps\Demo\Entity\DetallePeriodo;
use Pidia\Apps\Demo\Repository\BaseRepository;

class DetallePeriodoManager extends BaseManager
{
    public function repositorio(): BaseRepository|EntityRepository
    {
        return $this->manager()->getRepository(DetallePeriodo::class);
    }
}