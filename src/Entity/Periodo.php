<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Repository\PeriodoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeriodoRepository::class)]
#[HasLifecycleCallbacks]
class Periodo
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nombre;

    #[ORM\Column(type: 'string', length: 16)]
    private $alias;

    #[ORM\Column(type: 'text', nullable: true)]
    private $descripcion;

    #[ORM\Column(type: 'date')]
    private $fechaInicio;

    #[ORM\Column(type: 'date')]
    private $fechaFinal;

    #[ORM\ManyToMany(targetEntity: Producto::class)]
    private $productos;

    #[ORM\OneToMany(mappedBy: 'periodo', targetEntity: DetallePeriodo::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private $detalles;

    #[ORM\Column(type: 'string', length: 10)]
    private $estado;

    public function __construct()
    {
        $this->productos = new ArrayCollection();
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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $fechaInicio): self
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFinal(): ?\DateTimeInterface
    {
        return $this->fechaFinal;
    }

    public function setFechaFinal(\DateTimeInterface $fechaFinal): self
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * @return Collection|Producto[]
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function addProducto(Producto $producto): self
    {
        if (!$this->productos->contains($producto)) {
            $this->productos[] = $producto;
        }

        return $this;
    }

    public function removeProducto(Producto $producto): self
    {
        $this->productos->removeElement($producto);

        return $this;
    }
<<<<<<< HEAD

    /**
     * @return Collection|DetallePeriodo[]
     */
    public function getDetalles(): Collection
    {
        return $this->detalles;
    }

    public function addDetalle(DetallePeriodo $detalle): self
    {
        if (!$this->detalles->contains($detalle)) {
            $this->detalles[] = $detalle;
            $detalle->setPeriodo($this);
        }

        return $this;
    }

    public function removeDetalle(DetallePeriodo $detalle): self
    {
        if ($this->detalles->removeElement($detalle)) {
            // set the owning side to null (unless already changed)
            if ($detalle->getPeriodo() === $this) {
                $detalle->setPeriodo(null);
            }
        }

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNombre() ?? '';
=======
    public function __toString(): string
    {
        return $this->getNombre();
>>>>>>> 94cd187dc4e5223514658f355b9c0f5640cac217
    }
}
