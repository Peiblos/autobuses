<?php

namespace App\Entity;

use App\Repository\ItinerarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItinerarioRepository::class)]
class Itinerario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $origen = null;

    #[ORM\Column(length: 255)]
    private ?string $destino = null;

    #[ORM\OneToMany(mappedBy: 'itinerario', targetEntity: Viaje::class)]
    private Collection $viajes;

    public function __construct()
    {
        $this->viajes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrigen(): ?string
    {
        return $this->origen;
    }

    public function setOrigen(string $origen): static
    {
        $this->origen = $origen;

        return $this;
    }

    public function getDestino(): ?string
    {
        return $this->destino;
    }

    public function setDestino(string $destino): static
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * @return Collection<int, Viaje>
     */
    public function getViajes(): Collection
    {
        return $this->viajes;
    }

    public function addViaje(Viaje $viaje): static
    {
        if (!$this->viajes->contains($viaje)) {
            $this->viajes->add($viaje);
            $viaje->setItinerario($this);
        }

        return $this;
    }

    public function removeViaje(Viaje $viaje): static
    {
        if ($this->viajes->removeElement($viaje)) {
            // set the owning side to null (unless already changed)
            if ($viaje->getItinerario() === $this) {
                $viaje->setItinerario(null);
            }
        }

        return $this;
    }
}
