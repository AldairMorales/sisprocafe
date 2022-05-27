<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
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

    #[ORM\Column(type: 'measure', nullable: true)]
    private $muestra;


    #[ORM\Column(type: 'integer', nullable: true)]
    private $humedad = 12;

    #[ORM\Column(type: 'string', length: 100)]
    private $descripcion;

    #[ORM\OneToOne(targetEntity: Acopio::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $acopio;

    #[ORM\Column(type: 'measure', nullable: true)]
    private $exportable;

    #[ORM\Column(type: 'measure', nullable: true)]
    private $segunda;

    #[ORM\Column(type: 'measure', nullable: true)]
    private $bola;

    #[ORM\Column(type: 'measure', nullable: true)]
    private $cascara;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $exportableP;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $segundaP;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $bolaP;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $cascaraP;




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

    public function getMuestra()
    {
        return $this->muestra;
    }

    public function setMuestra($muestra): self
    {
        $this->muestra = $muestra;

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

    public function getAcopio(): ?Acopio
    {
        return $this->acopio;
    }

    public function setAcopio(Acopio $acopio): self
    {
        $this->acopio = $acopio;

        return $this;
    }

    public function getExportable()
    {
        return $this->exportable;
    }

    public function setExportable($exportable): self
    {
        $this->exportable = $exportable;

        return $this;
    }

    public function getSegunda()
    {
        return $this->segunda;
    }

    public function setSegunda($segunda): self
    {
        $this->segunda = $segunda;

        return $this;
    }

    public function getBola()
    {
        return $this->bola;
    }

    public function setBola($bola): self
    {
        $this->bola = $bola;

        return $this;
    }

    public function getCascara()
    {
        return $this->cascara;
    }

    public function setCascara($cascara): self
    {
        $this->cascara = $cascara;

        return $this;
    }

    public function getExportableP(): ?string
    {
        return $this->exportableP;
    }

    public function setExportableP(?string $exportableP): self
    {
        $this->exportableP = $exportableP;

        return $this;
    }

    public function getSegundaP(): ?string
    {
        return $this->segundaP;
    }

    public function setSegundaP(?string $segundaP): self
    {
        $this->segundaP = $segundaP;

        return $this;
    }

    public function getBolaP(): ?string
    {
        return $this->bolaP;
    }

    public function setBolaP(?string $bolaP): self
    {
        $this->bolaP = $bolaP;

        return $this;
    }

    public function getCascaraP(): ?string
    {
        return $this->cascaraP;
    }

    public function setCascaraP(?string $cascaraP): self
    {
        $this->cascaraP = $cascaraP;

        return $this;
    }
}
