<?php

namespace Pidia\Apps\Demo\Entity;

use Pidia\Apps\Demo\Repository\AnalisisFisicoRepository;
use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;

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

    #[ORM\Column(type: 'integer', nullable: true)]
    private $exportable;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $bola;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $segunda;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $humedad;

    #[ORM\Column(type: 'string', length: 100)]
    private $descripcion;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $cascara;

    #[ORM\OneToOne(targetEntity: Acopio::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $acopio;

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

    public function getExportable(): ?int
    {
        return $this->exportable;
    }

    public function setExportable(?int $exportable): self
    {
        $this->exportable = $exportable;

        return $this;
    }

    public function getBola(): ?int
    {
        return $this->bola;
    }

    public function setBola(?int $bola): self
    {
        $this->bola = $bola;

        return $this;
    }

    public function getSegunda(): ?int
    {
        return $this->segunda;
    }

    public function setSegunda(?int $segunda): self
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

    public function getCascara(): ?int
    {
        return $this->cascara;
    }

    public function setCascara(?int $cascara): self
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
}
