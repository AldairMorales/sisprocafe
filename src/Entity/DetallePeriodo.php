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

    #[ORM\Column(type: 'measure', nullable: true)]
    private $tara;

    #[ORM\Column(type: 'string', length: 15)]
    private $humedadInicial;

    #[ORM\Column(type: 'measure', nullable: true)]
    private $muestra;

    #[ORM\ManyToOne(targetEntity: Periodo::class, inversedBy: 'detalles')]
    #[ORM\JoinColumn(nullable: false)]
    private $periodo;

    public function __construct()
    {
        //        $this->certificaciones = new ArrayCollection();
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

    public function getTara()
    {
        return $this->tara;
    }

    public function setTara($tara): self
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

    public function getMuestra()
    {
        return $this->muestra;
    }

    public function setMuestra($muestra): self
    {
        $this->muestra = $muestra;

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
}
