<?php

namespace Pidia\Apps\Demo\Entity;

use Pidia\Apps\Demo\Repository\UnidadEquivalenciaRepository;
use Doctrine\ORM\Mapping as ORM;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;

#[ORM\Entity(repositoryClass: UnidadEquivalenciaRepository::class)]
#[ORM\HasLifecycleCallbacks]
class UnidadEquivalencia
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private $unidad;

    #[ORM\ManyToOne(targetEntity: UnidadMedida::class)]
    private $unidadMedida;

    #[ORM\Column(type: 'integer')]
    private $valorEquivalencia;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnidad(): ?string
    {
        return $this->unidad;
    }

    public function setUnidad(string $unidad): self
    {
        $this->unidad = $unidad;

        return $this;
    }

    public function getUnidadMedida(): ?UnidadMedida
    {
        return $this->unidadMedida;
    }

    public function setUnidadMedida(?UnidadMedida $unidadMedida): self
    {
        $this->unidadMedida = $unidadMedida;

        return $this;
    }

    public function getValorEquivalencia(): ?int
    {
        return $this->valorEquivalencia;
    }

    public function setValorEquivalencia(int $valorEquivalencia): self
    {
        $this->valorEquivalencia = $valorEquivalencia;

        return $this;
    }
    public function __ToString(): string
    {
        return $this->getUnidad();
    }
}
