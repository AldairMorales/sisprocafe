<?php

namespace Pidia\Apps\Demo\Entity;

use Pidia\Apps\Demo\Repository\AnalisisSensorialRepository;
use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;

#[ORM\Entity(repositoryClass: AnalisisSensorialRepository::class)]
#[ORM\HasLifecycleCallbacks]
class AnalisisSensorial
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

    #[ORM\ManyToOne(targetEntity: Certificacion::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $certificacion;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $puntaje;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $fragrancia;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $sabor;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $saborResidual;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $acidez;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $cuerpo;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $balance;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $puntajeCatador;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $descripcion;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $uniformidad;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $tasaLimpia;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $dulzor;

    #[ORM\OneToOne(targetEntity: Acopio::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $acopio;


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

    public function getCertificacion(): ?Certificacion
    {
        return $this->certificacion;
    }

    public function setCertificacion(?Certificacion $certificacion): self
    {
        $this->certificacion = $certificacion;

        return $this;
    }

    public function getPuntaje(): ?string
    {
        return $this->puntaje;
    }

    public function setPuntaje(?string $puntaje): self
    {
        $this->puntaje = $puntaje;

        return $this;
    }

    public function getFragrancia(): ?string
    {
        return $this->fragrancia;
    }

    public function setFragrancia(?string $fragrancia): self
    {
        $this->fragrancia = $fragrancia;

        return $this;
    }

    public function getSabor(): ?string
    {
        return $this->sabor;
    }

    public function setSabor(?string $sabor): self
    {
        $this->sabor = $sabor;

        return $this;
    }

    public function getSaborResidual(): ?string
    {
        return $this->saborResidual;
    }

    public function setSaborResidual(?string $saborResidual): self
    {
        $this->saborResidual = $saborResidual;

        return $this;
    }

    public function getAcidez(): ?string
    {
        return $this->acidez;
    }

    public function setAcidez(?string $acidez): self
    {
        $this->acidez = $acidez;

        return $this;
    }

    public function getCuerpo(): ?string
    {
        return $this->cuerpo;
    }

    public function setCuerpo(?string $cuerpo): self
    {
        $this->cuerpo = $cuerpo;

        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(?string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getPuntajeCatador(): ?string
    {
        return $this->puntajeCatador;
    }

    public function setPuntajeCatador(?string $puntajeCatador): self
    {
        $this->puntajeCatador = $puntajeCatador;

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

    public function getUniformidad(): ?string
    {
        return $this->uniformidad;
    }

    public function setUniformidad(?string $uniformidad): self
    {
        $this->uniformidad = $uniformidad;

        return $this;
    }

    public function getTasaLimpia(): ?string
    {
        return $this->tasaLimpia;
    }

    public function setTasaLimpia(?string $tasaLimpia): self
    {
        $this->tasaLimpia = $tasaLimpia;

        return $this;
    }

    public function getDulzor(): ?string
    {
        return $this->dulzor;
    }

    public function setDulzor(?string $dulzor): self
    {
        $this->dulzor = $dulzor;

        return $this;
    }

    public function getAcopio(): ?Acopio
    {
        return $this->acopio;
    }

    public function setAcopio(Acopio $acopio): self
    {
        $this->acopio = $acopio;

        return $this;
    }
}
