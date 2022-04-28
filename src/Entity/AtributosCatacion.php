<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Pidia\Apps\Demo\Repository\AtributosCatacionRepository;
use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;

#[ORM\Entity(repositoryClass: AtributosCatacionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class AtributosCatacion
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $nombre;

    #[ORM\OneToMany(mappedBy: 'atributoCatacion', targetEntity: DetalleAtributos::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private $detalles;

    public function __construct()
    {
        $this->detalles = new ArrayCollection();
    }

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

    /**
     * @return Collection|DetalleAtributos[]
     */
    public function getDetalles(): Collection
    {
        return $this->detalles;
    }

    public function addDetalle(DetalleAtributos $detalle): self
    {
        if (!$this->detalles->contains($detalle)) {
            $this->detalles[] = $detalle;
            $detalle->setAtributoCatacion($this);
        }

        return $this;
    }

    public function removeDetalle(DetalleAtributos $detalle): self
    {
        if ($this->detalles->removeElement($detalle)) {
            // set the owning side to null (unless already changed)
            if ($detalle->getAtributoCatacion() === $this) {
                $detalle->setAtributoCatacion(null);
            }
        }

        return $this;
    }
    public function __ToString(): string
    {
        return $this->getNombre();
    }
}
