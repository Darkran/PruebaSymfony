<?php

namespace App\Entity;

use App\Repository\MaquinasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\src\Enum\Tipos;

#[ORM\Entity(repositoryClass: MaquinasRepository::class)]
class Maquinas {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    private ?clientes $Cliente = null;

    #[ORM\ManyToMany(targetEntity: Videos::class)]
    private Collection $videos;
    
    #[Column(type: "string", enumType: Tipos::class)]
    private Tipos $tipo;
    

    public function __construct() {
        $this->videos = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNombre(): ?string {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): static {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getCliente(): ?clientes {
        return $this->Cliente;
    }

    public function setCliente(?clientes $Cliente): static {
        $this->Cliente = $Cliente;

        return $this;
    }

    /**
     * @return Collection<int, Videos>
     */
    public function getVideos(): Collection {
        return $this->videos;
    }

    public function addVideo(Videos $video): static {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
        }

        return $this;
    }

    public function removeVideo(Videos $video): static {
        $this->videos->removeElement($video);

        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getTipo(): ?string {
        return $this->tipo;
    }

    public function setTipo(Tipos $tipo): self {
        $this->tipo = $tipo;

        return $this;
    }
}
