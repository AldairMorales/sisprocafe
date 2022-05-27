<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Pidia\Apps\Demo\Repository\DetalleTrasladoRepository;

#[ORM\Entity(repositoryClass: DetalleTrasladoRepository::class)]
class DetalleTraslado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Producto::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $producto;

    #[ORM\ManyToOne(targetEntity: Certificacion::class)]
    private $certificacion;

    #[ORM\Column(type: 'measure')]
    private $peso;

    #[ORM\Column(type: 'measure')]
    private $cantidad;

    #[ORM\ManyToOne(targetEntity: Traslado::class, inversedBy: 'detalleTraslado')]
    #[ORM\JoinColumn(nullable: false)]
    private $traslados;

    public function __construct()
    {
        $this->traslados = new ArrayCollection();
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

    public function getCertificacion(): ?Certificacion
    {
        return $this->certificacion;
    }

    public function setCertificacion(?Certificacion $certificacion): self
    {
        $this->certificacion = $certificacion;

        return $this;
    }

    public function getPeso()
    {
        return $this->peso;
    }

    public function setPeso($peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getTraslados(): ?Traslado
    {
        return $this->traslados;
    }

    public function setTraslados(?Traslado $traslados): self
    {
        $this->traslados = $traslados;

        return $this;
    }
}
