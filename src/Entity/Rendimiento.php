<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Pidia\Apps\Demo\Repository\RendimientoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendimientoRepository::class)]
class Rendimiento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $valor;

    #[ORM\Column(type: 'integer')]
    private $incremento;

    #[ORM\ManyToOne(targetEntity: PrecioAcopio::class, inversedBy: 'rendimiento')]
    private $detalleRendimiento;


    public function __construct()
    {
        $this->detalleRendimiento = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValor(): ?int
    {
        return $this->valor;
    }

    public function setValor(int $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getIncremento(): ?int
    {
        return $this->incremento;
    }

    public function setIncremento(int $incremento): self
    {
        $this->incremento = $incremento;

        return $this;
    }

    public function getDetalleRendimiento(): ?PrecioAcopio
    {
        return $this->detalleRendimiento;
    }

    public function setDetalleRendimiento(?PrecioAcopio $detalleRendimiento): self
    {
        $this->detalleRendimiento = $detalleRendimiento;

        return $this;
    }
}
