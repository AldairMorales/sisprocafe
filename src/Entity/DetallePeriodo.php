<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Repository\DetallePeriodoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetallePeriodoRepository::class)]
#[HasLifecycleCallbacks]
class DetallePeriodo
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Producto::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $producto;

    #[ORM\Column(type: 'string', length: 30)]
    private $acciones;

    #[ORM\Column(type: 'string', length: 15)]
    private $tara;

    #[ORM\Column(type: 'string', length: 15)]
    private $humedadInicial;

    #[ORM\Column(type: 'string', length: 15)]
    private $muestra;

    #[ORM\Column(type: 'string', length: 10)]
    private $unidadMedida;

    #[ORM\Column(type: 'string', length: 10)]
    private $envase;

    #[ORM\Column(type: 'string', length: 8)]
    private $moneda;

    #[ORM\OneToMany(mappedBy: 'detallePeriodo', targetEntity: Certificacion::class)]
    private $certificaciones;

    #[ORM\ManyToOne(targetEntity: Periodo::class, inversedBy: 'detalles')]
    #[ORM\JoinColumn(nullable: false)]
    private $periodo;

    public function __construct()
    {
        $this->certificaciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getAcciones(): ?string
    {
        return $this->acciones;
    }

    public function setAcciones(string $acciones): self
    {
        $this->acciones = $acciones;

        return $this;
    }

    public function getTara(): ?string
    {
        return $this->tara;
    }

    public function setTara(string $tara): self
    {
        $this->tara = $tara;

        return $this;
    }

    public function getHumedadInicial(): ?string
    {
        return $this->humedadInicial;
    }

    public function setHumedadInicial(string $humedadInicial): self
    {
        $this->humedadInicial = $humedadInicial;

        return $this;
    }

    public function getMuestra(): ?string
    {
        return $this->muestra;
    }

    public function setMuestra(string $muestra): self
    {
        $this->muestra = $muestra;

        return $this;
    }

    public function getUnidadMedida(): ?string
    {
        return $this->unidadMedida;
    }

    public function setUnidadMedida(string $unidadMedida): self
    {
        $this->unidadMedida = $unidadMedida;

        return $this;
    }

    public function getEnvase(): ?string
    {
        return $this->envase;
    }

    public function setEnvase(string $envase): self
    {
        $this->envase = $envase;

        return $this;
    }

    public function getMoneda(): ?string
    {
        return $this->moneda;
    }

    public function setMoneda(string $moneda): self
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * @return Collection|Certificacion[]
     */
    public function getCertificaciones(): Collection
    {
        return $this->certificaciones;
    }

    public function addCertificacione(Certificacion $certificacione): self
    {
        if (!$this->certificaciones->contains($certificacione)) {
            $this->certificaciones[] = $certificacione;
            $certificacione->setDetallePeriodo($this);
        }

        return $this;
    }

    public function removeCertificacione(Certificacion $certificacione): self
    {
        if ($this->certificaciones->removeElement($certificacione)) {
            // set the owning side to null (unless already changed)
            if ($certificacione->getDetallePeriodo() === $this) {
                $certificacione->setDetallePeriodo(null);
            }
        }

        return $this;
    }

    public function getPeriodo(): ?Periodo
    {
        return $this->periodo;
    }

    public function setPeriodo(?Periodo $periodo): self
    {
        $this->periodo = $periodo;

        return $this;
    }

    public function __toString()
    {
        return $this->getMoneda();
    }
}
