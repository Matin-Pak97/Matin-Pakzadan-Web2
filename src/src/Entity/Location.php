<?php

namespace App\Entity;

use App\Model\TimeInterface;
use App\Model\UserInterface;
use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location extends Attraction implements TimeInterface, UserInterface
{
    #[ORM\Column(type: 'string', length: 255)]
    private $longitude;

    #[ORM\Column(type: 'string', length: 255)]
    private $latitude;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
}
