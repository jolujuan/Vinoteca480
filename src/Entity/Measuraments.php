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
    #[ORM\Column]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[Groups(['wine_details'])]
    private ?int $id = null;

    #[ORM\Column(name: "año")]
    #[Groups(['wine_details'])]
    private ?int $year = null;

    #[ORM\ManyToOne(targetEntity: Sensors::class)]
    #[ORM\JoinColumn(name: "id_sensor", referencedColumnName: "id", nullable: false)]
    #[Groups(['wine_details'])]
    private Sensors $sensor;

    #[ORM\ManyToOne(targetEntity: Wines::class)]
    #[ORM\JoinColumn(name: "id_vino", referencedColumnName: "id", nullable: false)]
    #[Groups(['wine_details'])]
    private Wines $wine;

    #[ORM\Column(length: 15)]
    #[Groups(['wine_details'])]
    private ?string $color = null;

    #[ORM\Column(name: "temperatura")]
    #[Groups(['wine_details'])]
    private ?float $temperature = null;

    #[ORM\Column(name: "graduacion")]
    #[Groups(['wine_details'])]
    private ?float $graduation = null;

    #[ORM\Column]
    #[Groups(['wine_details'])]
    private ?float $ph = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

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

    public function getWine(): Wines
    {
        return $this->wine;
    }

    public function setWine(Wines $wine): self
    {
        $this->wine = $wine;

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

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getGraduation(): ?float
    {
        return $this->graduation;
    }

    public function setGraduation(float $graduation): static
    {
        $this->graduation = $graduation;

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
