<?php

namespace App\Entity;

use App\Repository\BilleteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BilleteRepository::class)]
class Billete
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'comprador')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Viaje $viaje = null;

    #[ORM\ManyToOne(inversedBy: 'billetes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $comprador = null;
    #[ORM\Column]
    private ?int $fila = null;

    #[ORM\Column]
    private ?int $columna = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getViaje(): ?Viaje
    {
        return $this->viaje;
    }

    public function setViaje(?Viaje $viaje): static
    {
        $this->viaje = $viaje;

        return $this;
    }

    public function getComprador(): ?User
    {
        return $this->comprador;
    }

    public function setComprador(?User $comprador): static
    {
        $this->comprador = $comprador;

        return $this;
    }

    public function getFila(): ?int
    {
        return $this->fila;
    }

    public function setFila($fila): static
    {
        $this->fila = $fila;

        return $this;
    }

    public function getColumna(): ?User
    {
        return $this->columna;
    }

    public function setColumna($columna): static
    {
        $this->columna = $columna;

        return $this;
    }
}
