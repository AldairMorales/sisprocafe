<?php

namespace Pidia\Apps\Demo\Entity;

use Pidia\Apps\Demo\Repository\DetalleAtributosRepository;
use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;

#[ORM\Entity(repositoryClass: DetalleAtributosRepository::class)]
#[ORM\HasLifecycleCallbacks]
class DetalleAtributos
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nombre;

    #[ORM\ManyToOne(targetEntity: AtributosCatacion::class, inversedBy: 'detalles')]
    #[ORM\JoinColumn(nullable: false)]
    private $atributoCatacion;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAtributoCatacion(): ?AtributosCatacion
    {
        return $this->atributoCatacion;
    }

    public function setAtributoCatacion(?AtributosCatacion $atributoCatacion): self
    {
        $this->atributoCatacion = $atributoCatacion;

        return $this;
    }
    public function __ToString(): string
    {
        return $this->getNombre();
    }
}
