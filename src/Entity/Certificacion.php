<?php

namespace Pidia\Apps\Demo\Entity;

use Pidia\Apps\Demo\Repository\CertificacionRepository;
use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;

#[ORM\Entity(repositoryClass: CertificacionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Certificacion
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nombre;

    #[ORM\Column(type: 'string', length: 30)]
    private $alias;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $padre;

    #[ORM\ManyToOne(targetEntity: DetallePeriodo::class, inversedBy: 'certificaciones')]
    #[ORM\JoinColumn(nullable: false)]
    private $detallePeriodo;

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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getPadre(): ?self
    {
        return $this->padre;
    }

    public function setPadre(?self $padre): self
    {
        $this->padre = $padre;

        return $this;
    }
    public function __toString(): string
    {
        return $this->getNombre() ?? '';
    }

    public function getDetallePeriodo(): ?DetallePeriodo
    {
        return $this->detallePeriodo;
    }

    public function setDetallePeriodo(?DetallePeriodo $detallePeriodo): self
    {
        $this->detallePeriodo = $detallePeriodo;

        return $this;
    }
}
