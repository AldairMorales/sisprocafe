<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Repository\PagoAcopioRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: PagoAcopioRepository::class)]
#[HasLifecycleCallbacks]
class PagoAcopio
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $fecha;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $precioBase;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $precioFinal;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $descripcion;

    #[ORM\OneToOne(targetEntity: Acopio::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private $acopio;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $pagoAcopio;

    #[ORM\ManyToOne(targetEntity: Parametro::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $estadoPago;

    public function __construct()
    {
        $this->fecha = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getPrecioBase(): ?string
    {
        return $this->precioBase;
    }

    public function setPrecioBase(?string $precioBase): self
    {
        $this->precioBase = $precioBase;

        return $this;
    }

    public function getPrecioFinal(): ?string
    {
        return $this->precioFinal;
    }

    public function setPrecioFinal(?string $precioFinal): self
    {
        $this->precioFinal = $precioFinal;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getAcopio(): ?Acopio
    {
        return $this->acopio;
    }

    public function setAcopio(?Acopio $acopio): self
    {
        $this->acopio = $acopio;

        return $this;
    }

    public function getPagoAcopio(): ?string
    {
        return $this->pagoAcopio;
    }

    public function setPagoAcopio(?string $pagoAcopio): self
    {
        $this->pagoAcopio = $pagoAcopio;

        return $this;
    }

    public function getEstadoPago(): ?Parametro
    {
        return $this->estadoPago;
    }

    public function setEstadoPago(?Parametro $estadoPago): self
    {
        $this->estadoPago = $estadoPago;

        return $this;
    }
}
