<?php


declare(strict_types=1);

namespace Pidia\Apps\Demo\Entity\ValueObject;



final class Measure
{
    public function __construct(private  float  $valor, private  string $unidad)
    {
    }
    public function valor(): float
    {
        return $this->valor;
    }
    public function unidad(): string
    {
        return $this->unidad;
    }
}
