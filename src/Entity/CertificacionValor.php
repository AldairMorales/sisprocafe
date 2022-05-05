<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Pidia\Apps\Demo\Repository\CertificacionValorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertificacionValorRepository::class)]
class CertificacionValor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Certificacion::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $certificacion;

    #[ORM\Column(type: 'integer')]
    private $valor;

    #[ORM\Column(type: 'integer')]
    private $diferencia;

    #[ORM\ManyToOne(targetEntity: PrecioAcopio::class, inversedBy: 'certificacionValor')]
    private $detalleCertificacion;

    public function __construct()
    {
        $this->detalleCertificaciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValor(): ?int
    {
        return $this->valor;
    }

    public function setValor(int $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getDiferencia(): ?int
    {
        return $this->diferencia;
    }

    public function setDiferencia(int $diferencia): self
    {
        $this->diferencia = $diferencia;

        return $this;
    }

    public function getDetalleCertificacion(): ?PrecioAcopio
    {
        return $this->detalleCertificacion;
    }

    public function setDetalleCertificacion(?PrecioAcopio $detalleCertificacion): self
    {
        $this->detalleCertificacion = $detalleCertificacion;

        return $this;
    }
}
