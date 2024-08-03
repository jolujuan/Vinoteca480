<?php

namespace App\Entity;

use App\Repository\SensorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SensorRepository::class)]
#[ORM\Table(name: "sensores")]
class Sensors
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[Groups(['sensor_details', 'wine_details'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Users::class)]
    #[ORM\JoinColumn(name: "id_usuario", referencedColumnName: "id", nullable: false)]
    #[Groups(['sensor_details'])]
    private Users $user;

    #[ORM\Column(name: "nombre", length: 50)]
    #[Groups(['sensor_details'])]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUser(): Users
    {
        return $this->user;
    }

    public function setUser(Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
