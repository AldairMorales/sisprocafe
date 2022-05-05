<?php

namespace Pidia\Apps\Demo\Entity;

use Pidia\Apps\Demo\Repository\SensorialUsuarioRepository;
use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;

#[ORM\Entity(repositoryClass: SensorialUsuarioRepository::class)]
#[ORM\HasLifecycleCallbacks]
class SensorialUsuario
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

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

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $uniformidad;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $tasaLimpia;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $dulzor;

    #[ORM\ManyToOne(targetEntity: Usuario::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $usuario;

    #[ORM\ManyToOne(targetEntity: AnalisisSensorial::class, inversedBy: 'sensorialUsuarios', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $analisisSensorial;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getAnalisisSensorial(): ?AnalisisSensorial
    {
        return $this->analisisSensorial;
    }

    public function setAnalisisSensorial(?AnalisisSensorial $analisisSensorial): self
    {
        $this->analisisSensorial = $analisisSensorial;

        return $this;
    }
}
