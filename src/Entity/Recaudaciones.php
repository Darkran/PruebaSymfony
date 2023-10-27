<?php

namespace App\Entity;

use App\Repository\RecaudacionesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecaudacionesRepository::class)]
class Recaudaciones
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column]
    private ?float $cantidad = null;

    #[ORM\ManyToOne]
    private ?Maquinas $Maquina = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    public function setCantidad(float $cantidad): static
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getMaquina(): ?Maquinas
    {
        return $this->Maquina;
    }

    public function setMaquina(?Maquinas $Maquina): static
    {
        $this->Maquina = $Maquina;

        return $this;
    }
}
