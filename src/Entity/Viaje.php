<?php

namespace App\Entity;

use App\Repository\ViajeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ViajeRepository::class)]
class Viaje
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Autobus $autobus = null;

    #[ORM\ManyToOne(inversedBy: 'viajes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Itinerario $itinerario = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Horario $horario = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $asientos = [];

    #[ORM\OneToMany(mappedBy: 'viaje', targetEntity: Billete::class)]
    private Collection $billetes;

    public function __construct()
    {
        $this->billetes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAutobus(): ?Autobus
    {
        return $this->autobus;
    }

    public function setAutobus(?Autobus $autobus): static
    {
        $this->autobus = $autobus;

        return $this;
    }

    public function getItinerario(): ?Itinerario
    {
        return $this->itinerario;
    }

    public function setItinerario(?Itinerario $itinerario): static
    {
        $this->itinerario = $itinerario;

        return $this;
    }

    public function getHorario(): ?Horario
    {
        return $this->horario;
    }

    public function setHorario(?Horario $horario): static
    {
        $this->horario = $horario;

        return $this;
    }

    public function getAsientos(): array
    {
        return $this->asientos;
    }

    public function setAsientos(array $asientos): static
    {
        $this->asientos = $asientos;

        return $this;
    }

    /**
     * @return Collection<int, Billete>
     */
    public function getbilletes(): Collection
    {
        return $this->billetes;
    }

    public function addbilletes(Billete $billetes): static
    {
        if (!$this->billetes->contains($billetes)) {
            $this->billetes->add($billetes);
            $billetes->setViaje($this);
        }

        return $this;
    }

    public function removebilletes(Billete $billetes): static
    {
        if ($this->billetes->removeElement($billetes)) {
            // set the owning side to null (unless already changed)
            if ($billetes->getViaje() === $this) {
                $billetes->setViaje(null);
            }
        }

        return $this;
    }

    public function calcularAsientos() {
        $filasAutobus = $this->getAutobus()->getFilas();
            $columnasAutobus = $this->getAutobus()->getColumnas();
            $asientos = [];
            for ($i = 0; $i < $filasAutobus; $i++) {
                $asientosFilas = [];
                for ($j = 0; $j < $columnasAutobus; $j++) {
                    $asientosFilas[] = 1;
                }
                $asientos[] = $asientosFilas;
            }
            $this->setAsientos($asientos);
    }

    public function AsientosTotales() {
        $asientos = $this->getAsientos();
        $contador = 0;  
        foreach ($asientos as $fila) {
            foreach ($fila as $asiento) {
                if ($asiento == 1) {
                    $contador++;
                }
            }
        }
        return $contador;    
    }

    public function checkAsientosDisponibles($coordenadas): bool
    {
        $asientos = $this->getAsientos();
        foreach($coordenadas as $coordenada) {
            if($asientos[$coordenada[0] -1][$coordenada[1] - 1] == 0) {
                return false;
            }
        }
        return true;
    }
    
    public function quitarAsientos($coordenadas): void
    {
        $asientos = $this->getAsientos();
        foreach($coordenadas as $coordenada) {
            $asientos[$coordenada[0] -1][$coordenada[1] - 1] = 0;
        }  
        $this->setAsientos($asientos);
    }
}
