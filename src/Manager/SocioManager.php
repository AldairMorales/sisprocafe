<?php

namespace Pidia\Apps\Demo\Manager;

use Doctrine\ORM\EntityRepository;
use Pidia\Apps\Demo\Entity\Socio;
use Pidia\Apps\Demo\Repository\BaseRepository;

class SocioManager extends BaseManager
{
    public function repositorio(): BaseRepository|EntityRepository
    {
        return $this->manager()->getRepository(Socio::class);
    }
}