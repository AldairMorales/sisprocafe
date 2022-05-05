<?php

namespace Pidia\Apps\Demo\Manager;

use Doctrine\ORM\EntityRepository;
use Pidia\Apps\Demo\Entity\PrecioAcopio;
use Pidia\Apps\Demo\Repository\BaseRepository;

class PrecioAcopioManager extends BaseManager
{
    public function repositorio(): BaseRepository|EntityRepository
    {
        return $this->manager()->getRepository(PrecioAcopio::class);
    }
}
