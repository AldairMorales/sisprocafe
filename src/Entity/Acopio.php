<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Repository\AcopioRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AcopioRepository::class)]
#[HasLifecycleCallbacks]
class Acopio
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Periodo::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $periodo;

    #[ORM\Column(type: 'date')]
    private $fecha;

    #[ORM\ManyToOne(targetEntity: Socio::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $socio;

    #[ORM\ManyToOne(targetEntity: Certificacion::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $certificacion;

    #[ORM\ManyToOne(targetEntity: Almacen::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $almacen;

    #[ORM\Column(type: 'string', length: 9)]
    private $tikect;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $taraPorSaco = 0.25;

    #[ORM\Column(type: 'text', nullable: true)]
    private $observaciones;

    #[ORM\Column(type: 'boolean')]
    private $analisis_Fisico = false;

    #[ORM\Column(type: 'boolean')]
    private $analisis_Sensorial = false;

    #[ORM\Column(type: 'measure', nullable: true)]
    private $pesoBruto;

    #[ORM\Column(type: 'measure', nullable: true)]
    private $cantidad;

    #[ORM\Column(type: 'measure', nullable: true)]
    private $taraDeSacos;

    #[ORM\Column(type: 'measure', nullable: true)]
    private $pesoQuintales;

    #[ORM\Column(type: 'measure', nullable: true)]
    private $pesoNeto;

    #[ORM\ManyToOne(targetEntity: Parametro::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $estado;

    public function __construct()
    {
        $this->fecha = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeriodo(): ?Periodo
    {
        return $this->periodo;
    }

    public function setPeriodo(?Periodo $periodo): self
    {
        $this->periodo = $periodo;

        return $this;
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

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): self
    {
        $this->socio = $socio;

        return $this;
    }

    public function getCertificacion(): ?Certificacion
    {
        return $this->certificacion;
    }

    public function setCertificacion(?Certificacion $certificacion): self
    {
        $this->certificacion = $certificacion;

        return $this;
    }

    public function getAlmacen(): ?Almacen
    {
        return $this->almacen;
    }

    public function setAlmacen(?Almacen $almacen): self
    {
        $this->almacen = $almacen;

        return $this;
    }

    public function getTikect(): ?string
    {
        return $this->tikect;
    }

    public function setTikect(string $tikect): self
    {
        $this->tikect = $tikect;

        return $this;
    }

    public function getTaraPorSaco(): ?string
    {
        return $this->taraPorSaco;
    }

    public function setTaraPorSaco(string $taraPorSaco): self
    {
        $this->taraPorSaco = $taraPorSaco;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTikect() ?? '';
    }

    public function getAnalisisFisico(): ?bool
    {
        return $this->analisis_Fisico;
    }

    public function setAnalisisFisico(bool $analisis_Fisico): self
    {
        $this->analisis_Fisico = $analisis_Fisico;

        return $this;
    }

    public function getAnalisisSensorial(): ?bool
    {
        return $this->analisis_Sensorial;
    }

    public function setAnalisisSensorial(bool $analisis_Sensorial): self
    {
        $this->analisis_Sensorial = $analisis_Sensorial;

        return $this;
    }

    public function getPesoBruto()
    {
        return $this->pesoBruto;
    }

    public function setPesoBruto($pesoBruto): self
    {
        $this->pesoBruto = $pesoBruto;

        return $this;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getTaraDeSacos()
    {
        return $this->taraDeSacos;
    }

    public function setTaraDeSacos($taraDeSacos): self
    {
        $this->taraDeSacos = $taraDeSacos;

        return $this;
    }

    public function getPesoQuintales()
    {
        return $this->pesoQuintales;
    }

    public function setPesoQuintales($pesoQuintales): self
    {
        $this->pesoQuintales = $pesoQuintales;

        return $this;
    }

    public function getPesoNeto()
    {
        return $this->pesoNeto;
    }

    public function setPesoNeto($pesoNeto): self
    {
        $this->pesoNeto = $pesoNeto;

        return $this;
    }

    public function getEstado(): ?Parametro
    {
        return $this->estado;
    }

    public function setEstado(?Parametro $estado): self
    {
        $this->estado = $estado;

        return $this;
    }
}
