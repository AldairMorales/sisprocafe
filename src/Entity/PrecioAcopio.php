<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Pidia\Apps\Demo\Repository\PrecioAcopioRepository;
use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: PrecioAcopioRepository::class)]
#[HasLifecycleCallbacks]
class PrecioAcopio
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $precioBase;

    #[ORM\OneToMany(mappedBy: 'detalleRendimiento', targetEntity: Rendimiento::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private $rendimiento;

    #[ORM\OneToMany(mappedBy: 'detalleCertificacion', targetEntity: CertificacionValor::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private $certificacionValor;


    public function __construct()
    {
        $this->rendimiento = new ArrayCollection();
        $this->certificacionValor = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrecioBase(): ?string
    {
        return $this->precioBase;
    }

    public function setPrecioBase(string $precioBase): self
    {
        $this->precioBase = $precioBase;

        return $this;
    }

    /**
     * @return Collection|Rendimiento[]
     */
    public function getRendimiento(): Collection
    {
        return $this->rendimiento;
    }

    public function addRendimiento(Rendimiento $rendimiento): self
    {
        if (!$this->rendimiento->contains($rendimiento)) {
            $this->rendimiento[] = $rendimiento;
            $rendimiento->setDetalleRendimiento($this);
        }

        return $this;
    }

    public function removeRendimiento(Rendimiento $rendimiento): self
    {
        if ($this->rendimiento->removeElement($rendimiento)) {
            // set the owning side to null (unless already changed)
            if ($rendimiento->getDetalleRendimiento() === $this) {
                $rendimiento->setDetalleRendimiento(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CertificacionValor[]
     */
    public function getCertificacionValor(): Collection
    {
        return $this->certificacionValor;
    }

    public function addCertificacionValor(CertificacionValor $certificacionValor): self
    {
        if (!$this->certificacionValor->contains($certificacionValor)) {
            $this->certificacionValor[] = $certificacionValor;
            $certificacionValor->setDetalleCertificacion($this);
        }

        return $this;
    }

    public function removeCertificacionValor(CertificacionValor $certificacionValor): self
    {
        if ($this->certificacionValor->removeElement($certificacionValor)) {
            // set the owning side to null (unless already changed)
            if ($certificacionValor->getDetalleCertificacion() === $this) {
                $certificacionValor->setDetalleCertificacion(null);
            }
        }

        return $this;
    }
}
