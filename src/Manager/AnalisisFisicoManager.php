<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Manager;

use Pidia\Apps\Demo\Entity\AnalisisFisico;
use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Repository\BaseRepository;

final class AnalisisFisicoManager extends BaseManager
{
    public function repositorio(): BaseRepository
    {
        return $this->manager()->getRepository(AnalisisFisico::class);
    }
    public function actualizarAcopio(AnalisisFisico $fisico, ?Acopio $acopioAnterior = null): void
    {

        $acopio = $fisico->getAcopio();
        $acopio->setAnalisisFisico(true);
        $this->entityManager->persist($acopio);
        if (null !== $acopioAnterior && $acopio->getId() !== $acopioAnterior->getId()) {
            $acopioAnterior->setAnalisisFisico(false);
            if ($acopioAnterior->getAnalisisSensorial() === true) {
                $acopioAnterior->setAnalisisSensorial(false);
            }
            $this->entityManager->persist($acopioAnterior);
        }
    }
}
