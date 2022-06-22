<?php

namespace App\Entity;

use App\Model\TimeInterface;
use App\Model\UserInterface;
use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event extends Attraction implements TimeInterface, UserInterface
{
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $organizer;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $startDateTme;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $endDateTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrganizer(): ?User
    {
        return $this->organizer;
    }

    public function setOrganizer(?User $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getStartDateTme(): ?\DateTimeInterface
    {
        return $this->startDateTme;
    }

    public function setStartDateTme(?\DateTimeInterface $startDateTme): self
    {
        $this->startDateTme = $startDateTme;

        return $this;
    }

    public function getEndDateTime(): ?\DateTimeInterface
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(?\DateTimeInterface $endDateTime): self
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }
}
