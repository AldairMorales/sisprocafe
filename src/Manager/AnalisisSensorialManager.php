<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Manager;

use Pidia\Apps\Demo\Entity\AnalisisSensorial;
use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Repository\BaseRepository;

final class AnalisisSensorialManager extends BaseManager
{

    public function repositorio(): BaseRepository
    {
        return $this->manager()->getRepository(AnalisisSensorial::class);
    }
    public function actualizarAcopio(AnalisisSensorial $sensorial, ?Acopio $acopioAnterior = null): void
    {

        $acopio = $sensorial->getAcopio();
        $acopio->setAnalisisSensorial(true);
        $this->entityManager->persist($acopio);
        if (null !== $acopioAnterior && $acopio->getId() !== $acopioAnterior->getId()) {
            $acopioAnterior->setAnalisisSensorial(false);
            $this->entityManager->persist($acopioAnterior);
        }
    }
}
