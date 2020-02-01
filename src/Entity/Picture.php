<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please, upload the file")
     * @Assert\File(mimeTypes={ "application/jpg" })
     */
    private $path;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Meal", inversedBy="pictures")
     */
    private $meal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath( $path): self
    {
        $this->path = $path;

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
}
