<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\IdsTrait;
use App\Entity\Traits\EntityTimestampableTrait;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MealRepository")
 */
class Meal
{
    use IdsTrait;
    use EntityTimestampableTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TypeMeal", inversedBy="meals")
     */
    private $types;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="meal",cascade={"remove","persist"})
     */
    private $pictures;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", cascade={"remove","persist"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="meal")
     */
    private $bookings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notation", mappedBy="meal")
     */
    private $notations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="mealProposed")
     */
    private $host;

    /**
     *
     * @ORM\Column(type="datetime")
     */
    private $dateMeal;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxTraveller;


    public function __construct()
    {
        $this->types = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->notations = new ArrayCollection();
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPictures(): ?Collection
    {
        return $this->pictures;
    }

    public function setPictures(?Picture $pictures): self
    {
        $this->pictures = $pictures;

        return $this;
    }

    /**
     * @return Collection|TypeMeal[]
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(TypeMeal $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types[] = $type;
        }

        return $this;
    }

    public function removeType(TypeMeal $type): self
    {
        if ($this->types->contains($type)) {
            $this->types->removeElement($type);
        }

        return $this;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setMeal($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getMeal() === $this) {
                $picture->setMeal(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setMeal($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getMeal() === $this) {
                $booking->setMeal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notation[]
     */
    public function getNotations(): Collection
    {
        return $this->notations;
    }

    public function addNotation(Notation $notation): self
    {
        if (!$this->notations->contains($notation)) {
            $this->notations[] = $notation;
            $notation->setMeal($this);
        }

        return $this;
    }

    public function removeNotation(Notation $notation): self
    {
        if ($this->notations->contains($notation)) {
            $this->notations->removeElement($notation);
            // set the owning side to null (unless already changed)
            if ($notation->getMeal() === $this) {
                $notation->setMeal(null);
            }
        }

        return $this;
    }

    public function getHost(): ?User
    {
        return $this->host;
    }

    public function setHost(?User $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function getDateMeal(): ?\DateTimeInterface
    {
        return $this->dateMeal;
    }

    public function setDateMeal(\DateTimeInterface $dateMeal): self
    {
        $this->dateMeal = $dateMeal;

        return $this;
    }

    public function getMaxTraveller(): ?int
    {
        return $this->maxTraveller;
    }

    public function setMaxTraveller(int $maxTraveller): self
    {
        $this->maxTraveller = $maxTraveller;

        return $this;
    }
}
