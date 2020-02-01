<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPayed;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Meal", inversedBy="bookings")
     */
    private $meal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bookings")
     */
    private $traveler;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAccepted;

    public function __construct()
    {
        $this->isAccepted = false;
        $this->isPayed = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsPayed(): ?bool
    {
        return $this->isPayed;
    }

    public function setIsPayed(bool $isPayed): self
    {
        $this->isPayed = $isPayed;

        return $this;
    }

    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    public function setMeal(?Meal $meal): self
    {
        $this->meal = $meal;

        return $this;
    }

    public function getTraveler(): ?User
    {
        return $this->traveler;
    }

    public function setTraveler(?User $traveler): self
    {
        $this->traveler = $traveler;

        return $this;
    }

    public function getIsAccepted(): ?bool
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(bool $isAccepted): self
    {
        $this->isAccepted = $isAccepted;

        return $this;
    }
}
