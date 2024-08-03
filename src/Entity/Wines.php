<?php

namespace App\Entity;

use App\Repository\WineRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: WineRepository::class)]
#[ORM\Table(name:"vino")]
class Wines
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['wine_details'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Users::class)]
    #[ORM\JoinColumn(name:"id_usuario", referencedColumnName:"id", nullable:false)]
    #[Groups(['wine_details'])]
    private Users $usuario;

    #[ORM\Column(length: 50)]
    #[Groups(['wine_details'])]
    private ?string $nombre = null;

    #[ORM\Column]
    #[Groups(['wine_details'])]
    private ?int $año = null;

    #[ORM\OneToMany(targetEntity: Measuraments::class, mappedBy: "vino")]
    #[Groups(['wine_details'])]
    private Collection $measuraments;

    /**
     * @param Collection $measuraments
     */
    public function __construct(Collection $measuraments)
    {
        $this->measuraments = $measuraments;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUsuario(): Users
    {
        return $this->usuario;
    }

    public function setUsuario(Users $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getAño(): ?int
    {
        return $this->año;
    }

    public function setAño(int $año): static
    {
        $this->año = $año;

        return $this;
    }

    public function getMeasuraments(): Collection
    {
        return $this->measuraments;
    }


}
