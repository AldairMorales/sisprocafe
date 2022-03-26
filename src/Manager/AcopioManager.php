<?php

namespace Pidia\Apps\Demo\Manager;

use Doctrine\ORM\EntityRepository;
use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Repository\BaseRepository;

class AcopioManager extends BaseManager
{
    public function repositorio(): BaseRepository|EntityRepository
    {
        return $this->manager()->getRepository(Acopio::class);
    }
}