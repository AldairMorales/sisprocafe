<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Entity\ValueObject\Measure;
use Pidia\Apps\Demo\Repository\AnalisisFisicoRepository;

#[ORM\Entity(repositoryClass: AnalisisFisicoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class AnalisisFisico
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $fecha;

    #[ORM\ManyToOne(targetEntity: Certificacion::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $certificacion;

    #[ORM\Column(type: 'integer')]
    private $muestra;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $exportable;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $bola;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $segunda;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $cascara;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $humedad = 12;

    #[ORM\Column(type: 'string', length: 100)]
    private $descripcion;

    #[ORM\OneToOne(targetEntity: Acopio::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $acopio;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $exportable_;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $bola_;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $segunda_;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $cascara_;

    private ?Measure $tipo = null;

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

    public function getCertificacion(): ?Certificacion
    {
        return $this->certificacion;
    }

    public function setCertificacion(?Certificacion $certificacion): self
    {
        $this->certificacion = $certificacion;

        return $this;
    }

    public function getMuestra(): ?int
    {
        return $this->muestra;
    }

    public function setMuestra(int $muestra): self
    {
        $this->muestra = $muestra;

        return $this;
    }

    public function getExportable(): ?string
    {
        return $this->exportable;
    }

    public function setExportable(?string $exportable): self
    {
        $this->exportable = $exportable;

        return $this;
    }

    public function getBola(): ?string
    {
        return $this->bola;
    }

    public function setBola(?string $bola): self
    {
        $this->bola = $bola;

        return $this;
    }

    public function getSegunda(): ?string
    {
        return $this->segunda;
    }

    public function setSegunda(?string $segunda): self
    {
        $this->segunda = $segunda;

        return $this;
    }

    public function getHumedad(): ?int
    {
        return $this->humedad;
    }

    public function setHumedad(?int $humedad): self
    {
        $this->humedad = $humedad;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getCascara(): ?string
    {
        return $this->cascara;
    }

    public function setCascara(?string $cascara): self
    {
        $this->cascara = $cascara;

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

    public function getTipo(): ?Measure
    {
        return $this->tipo;
    }

    public function setTipo(?Measure $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }
}
