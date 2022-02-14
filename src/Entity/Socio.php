<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Repository\SocioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocioRepository::class)]
#[HasLifecycleCallbacks]
class Socio
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $fechaIngreso;

    #[ORM\Column(type: 'string', length: 16)]
    private $codigo;

    #[ORM\Column(type: 'boolean')]
    private $tipo;

    #[ORM\Column(type: 'string', length: 50)]
    private $nombres;

    #[ORM\Column(type: 'string', length: 30)]
    private $apellidoPaterno;

    #[ORM\Column(type: 'string', length: 30)]
    private $apellidoMaterno;

    #[ORM\Column(type: 'boolean')]
    private $sexo;

    #[ORM\Column(type: 'string', length: 15)]
    private $numeroDocumento;

    #[ORM\Column(type: 'string', length: 9)]
    private $telefono;

    #[ORM\Column(type: 'date')]
    private $fechaNacimiento;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $conyugueNombre;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private $conyugueDocumento;

    #[ORM\Column(type: 'string', length: 11)]
    private $ruc;

    #[ORM\Column(type: 'boolean')]
    private $estadoRuc;

    #[ORM\ManyToOne(targetEntity: EstadoSocio::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $estado;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaIngreso(): ?\DateTimeInterface
    {
        return $this->fechaIngreso;
    }

    public function setFechaIngreso(\DateTimeInterface $fechaIngreso): self
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getTipo(): ?bool
    {
        return $this->tipo;
    }

    public function setTipo(bool $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): self
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getApellidoPaterno(): ?string
    {
        return $this->apellidoPaterno;
    }

    public function setApellidoPaterno(string $apellidoPaterno): self
    {
        $this->apellidoPaterno = $apellidoPaterno;

        return $this;
    }

    public function getApellidoMaterno(): ?string
    {
        return $this->apellidoMaterno;
    }

    public function setApellidoMaterno(string $apellidoMaterno): self
    {
        $this->apellidoMaterno = $apellidoMaterno;

        return $this;
    }

    public function getSexo(): ?bool
    {
        return $this->sexo;
    }

    public function setSexo(bool $sexo): self
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getNumeroDocumento(): ?string
    {
        return $this->numeroDocumento;
    }

    public function setNumeroDocumento(string $numeroDocumento): self
    {
        $this->numeroDocumento = $numeroDocumento;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getConyugueNombre(): ?string
    {
        return $this->conyugueNombre;
    }

    public function setConyugueNombre(?string $conyugueNombre): self
    {
        $this->conyugueNombre = $conyugueNombre;

        return $this;
    }

    public function getConyugueDocumento(): ?string
    {
        return $this->conyugueDocumento;
    }

    public function setConyugueDocumento(?string $conyugueDocumento): self
    {
        $this->conyugueDocumento = $conyugueDocumento;

        return $this;
    }

    public function getRuc(): ?string
    {
        return $this->ruc;
    }

    public function setRuc(string $ruc): self
    {
        $this->ruc = $ruc;

        return $this;
    }

    public function getEstadoRuc(): ?bool
    {
        return $this->estadoRuc;
    }

    public function setEstadoRuc(bool $estadoRuc): self
    {
        $this->estadoRuc = $estadoRuc;

        return $this;
    }

    public function getEstado(): ?EstadoSocio
    {
        return $this->estado;
    }

    public function setEstado(?EstadoSocio $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNombres();
    }
}
