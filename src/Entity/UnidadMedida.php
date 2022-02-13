<?php

namespace Pidia\Apps\Demo\Entity;

use Pidia\Apps\Demo\Repository\UnidadMedidaRepository;
use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;

#[ORM\Entity(repositoryClass: UnidadMedidaRepository::class)]
#[ORM\HasLifecycleCallbacks]
class UnidadMedida
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: UnidadMedidaCategoria::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $categoria;

    #[ORM\Column(type: 'string', length: 50)]
    private $nombre;

    #[ORM\Column(type: 'string', length: 10)]
    private $simbolo;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $alias;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoria(): ?UnidadMedidaCategoria
    {
        return $this->categoria;
    }

    public function setCategoria(?UnidadMedidaCategoria $categoria): self
    {
        $this->categoria = $categoria;

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

    public function getSimbolo(): ?string
    {
        return $this->simbolo;
    }

    public function setSimbolo(string $simbolo): self
    {
        $this->simbolo = $simbolo;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }
    public function __ToString(): string
    {
        return $this->getNombre();
    }
}
