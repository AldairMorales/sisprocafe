<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Pidia\Apps\Demo\Repository\TrasladoRepository;
use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;


#[ORM\Entity(repositoryClass: TrasladoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Traslado
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $fechaSalida;

    #[ORM\Column(type: 'string', length: 9)]
    private $numeroGuia;

    #[ORM\ManyToOne(targetEntity: Almacen::class)]
    private $almacenOrigen;

    #[ORM\ManyToOne(targetEntity: Almacen::class)]
    private $almacenDestino;


    #[ORM\OneToMany(mappedBy: 'traslados', targetEntity: DetalleTraslado::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private $detalleTraslado;


    public function __construct()
    {
        $this->detalleTraslado = new ArrayCollection();
        $this->fechaSalida = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaSalida(): ?\DateTimeInterface
    {
        return $this->fechaSalida;
    }

    public function setFechaSalida(\DateTimeInterface $fechaSalida): self
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }

    public function getNumeroGuia(): ?string
    {
        return $this->numeroGuia;
    }

    public function setNumeroGuia(string $numeroGuia): self
    {
        $this->numeroGuia = $numeroGuia;

        return $this;
    }

    public function getAlmacenOrigen(): ?Almacen
    {
        return $this->almacenOrigen;
    }

    public function setAlmacenOrigen(?Almacen $almacenOrigen): self
    {
        $this->almacenOrigen = $almacenOrigen;

        return $this;
    }

    public function getAlmacenDestino(): ?Almacen
    {
        return $this->almacenDestino;
    }

    public function setAlmacenDestino(?Almacen $almacenDestino): self
    {
        $this->almacenDestino = $almacenDestino;

        return $this;
    }

    /**
     * @return Collection|DetalleTraslado[]
     */
    public function getDetalleTraslado(): Collection
    {
        return $this->detalleTraslado;
    }

    public function addDetalleTraslado(DetalleTraslado $detalleTraslado): self
    {
        if (!$this->detalleTraslado->contains($detalleTraslado)) {
            $this->detalleTraslado[] = $detalleTraslado;
            $detalleTraslado->setTraslados($this);
        }

        return $this;
    }

    public function removeDetalleTraslado(DetalleTraslado $detalleTraslado): self
    {
        if ($this->detalleTraslado->removeElement($detalleTraslado)) {
            // set the owning side to null (unless already changed)
            if ($detalleTraslado->getTraslados() === $this) {
                $detalleTraslado->setTraslados(null);
            }
        }

        return $this;
    }
}
