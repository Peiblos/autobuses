<?php

namespace App\Entity;

use App\Repository\AutobusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AutobusRepository::class)]
class Autobus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $filas = null;

    #[ORM\Column]
    private ?int $columnas = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilas(): ?int
    {
        return $this->filas;
    }

    public function setFilas(int $filas): static
    {
        $this->filas = $filas;

        return $this;
    }

    public function getColumnas(): ?int
    {
        return $this->columnas;
    }

    public function setColumnas(int $columnas): static
    {
        $this->columnas = $columnas;

        return $this;
    }
}
