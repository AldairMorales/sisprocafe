<?php

declare(strict_types=1);

namespace Pidia\Apps\Demo\Form\DTO;

final class ValorMedida
{
    public function __construct(
        private float $valor,
        private string $unidad,
    ) {
    }

    public function valor(): float
    {
        return $this->valor;
    }

    public function setValor(float $valor): void
    {
        $this->valor = $valor;
    }

    public function unidad(): string
    {
        return $this->unidad;
    }

    public function setUnidad(string $unidad): void
    {
        $this->unidad = $unidad;
    }
}
