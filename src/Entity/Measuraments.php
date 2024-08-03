<?php

namespace App\Entity;

use App\Repository\MeasuramentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MeasuramentRepository::class)]
#[ORM\Table(name: "mediciones")]
class Measuraments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['wine_details'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['wine_details'])]
    private ?int $año = null;

    #[ORM\ManyToOne(targetEntity: Sensors::class)]
    #[ORM\JoinColumn(name: "id_sensor", referencedColumnName: "id", nullable: false)]
    #[Groups(['wine_details'])]
    private Sensors $sensor;

    #[ORM\ManyToOne(targetEntity: Wines::class)]
    #[ORM\JoinColumn(name: "id_vino", referencedColumnName: "id", nullable: false)]
    #[Groups(['wine_details'])]
    private Wines $vino;

    #[ORM\Column(length: 15)]
    #[Groups(['wine_details'])]
    private ?string $color = null;

    #[ORM\Column]
    #[Groups(['wine_details'])]
    private ?float $temperatura = null;

    #[ORM\Column]
    #[Groups(['wine_details'])]
    private ?float $graduacion = null;

    #[ORM\Column]
    #[Groups(['wine_details'])]
    private ?float $ph = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSensor(): Sensors
    {
        return $this->sensor;
    }

    public function setSensor(Sensors $sensor): self
    {
        $this->sensor = $sensor;

        return $this;
    }

    public function getVino(): Wines
    {
        return $this->vino;
    }

    public function setVino(Wines $vino): self
    {
        $this->vino = $vino;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getTemperatura(): ?float
    {
        return $this->temperatura;
    }

    public function setTemperatura(float $temperatura): static
    {
        $this->temperatura = $temperatura;

        return $this;
    }

    public function getGraduacion(): ?float
    {
        return $this->graduacion;
    }

    public function setGraduacion(float $graduacion): static
    {
        $this->graduacion = $graduacion;

        return $this;
    }

    public function getPh(): ?float
    {
        return $this->ph;
    }

    public function setPh(float $ph): static
    {
        $this->ph = $ph;

        return $this;
    }
}
