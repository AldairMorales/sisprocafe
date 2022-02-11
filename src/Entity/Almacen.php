<?php

namespace Pidia\Apps\Demo\Entity;

use Pidia\Apps\Demo\Repository\AlmacenRepository;
use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;

#[ORM\Entity(repositoryClass: AlmacenRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Almacen
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: TipoAlmacen::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $tipoAlmacen;

    #[ORM\Column(type: 'string', length: 50)]
    private $nombre;

    #[ORM\ManyToOne(targetEntity: ReporteTerritorial::class)]
    private $ubicacion;

    #[ORM\ManyToOne(targetEntity: Almacen::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $empresa;

    #[ORM\Column(type: 'string', length: 80, nullable: true)]
    private $direccion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoAlmacen(): ?TipoAlmacen
    {
        return $this->tipoAlmacen;
    }

    public function setTipoAlmacen(?TipoAlmacen $tipoAlmacen): self
    {
        $this->tipoAlmacen = $tipoAlmacen;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getUbicacion(): ?ReporteTerritorial
    {
        return $this->ubicacion;
    }

    public function setUbicacion(?ReporteTerritorial $ubicacion): self
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    public function getEmpresa(): ?Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(?Empresa $empresa): self
    {
        $this->empresa = $empresa;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }
}
