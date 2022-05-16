<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Manager;

use Pidia\Apps\Demo\Entity\AnalisisSensorial;
use Pidia\Apps\Demo\Entity\Usuario;
use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Repository\BaseRepository;
use Pidia\Apps\Demo\Entity\SensorialUsuario;

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
    public function cambiarSensorialAcopio(Acopio $acopioAnterior): void
    {
        $acopioAnterior->setAnalisisSensorial(false);
        $this->entityManager->persist($acopioAnterior);
    }
    public function insertarAnalisis_Usuario(AnalisisSensorial $sensorial, Usuario $usuario, ?SensorialUsuario $sensorialUsuario = null): void
    {
        $sensorial_usuario = new SensorialUsuario();
        if (null === $sensorialUsuario) {
            $sensorial_usuario->setAnalisisSensorial($sensorial);
            $sensorial_usuario->setUsuario($usuario);
        } else {
            $sensorial_usuario = $sensorialUsuario;
        }
        $sensorial_usuario->setFragrancia($sensorial->getFragrancia());
        $sensorial_usuario->setSabor($sensorial->getSabor());
        $sensorial_usuario->setSaborResidual($sensorial->getSaborResidual());
        $sensorial_usuario->setAcidez($sensorial->getAcidez());
        $sensorial_usuario->setCuerpo($sensorial->getCuerpo());
        $sensorial_usuario->setBalance($sensorial->getBalance());
        $sensorial_usuario->setPuntajeCatador($sensorial->getPuntajeCatador());
        $this->entityManager->persist($sensorial_usuario);
        $this->entityManager->flush($sensorial_usuario);
    }
    public function actualizarAnalisiSensorial(AnalisisSensorial $analisisSensorial, array $PromedioSensorial)
    {
        if (null !== $PromedioSensorial) {
            $analisisSensorial->setPuntaje(sprintf("%.2f", $PromedioSensorial['fragrancia'] + $PromedioSensorial['sabor'] +
                $PromedioSensorial['saborResidual'] + $PromedioSensorial['acidez'] + $PromedioSensorial['cuerpo'] +
                $PromedioSensorial['balance'] + $PromedioSensorial['puntajeCatador'] + $analisisSensorial->getUniformidad() +
                $analisisSensorial->getTasaLimpia() + $analisisSensorial->getDulzor()));
            $analisisSensorial->setFragrancia($PromedioSensorial['fragrancia']);
            $analisisSensorial->setSabor($PromedioSensorial['sabor']);
            $analisisSensorial->setSaborResidual($PromedioSensorial['saborResidual']);
            $analisisSensorial->setAcidez($PromedioSensorial['acidez']);
            $analisisSensorial->setCuerpo($PromedioSensorial['cuerpo']);
            $analisisSensorial->setBalance($PromedioSensorial['balance']);
            $analisisSensorial->setPuntajeCatador($PromedioSensorial['puntajeCatador']);
            $this->entityManager->persist($analisisSensorial);
        }
    }
}
