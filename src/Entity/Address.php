<?php
namespace App\Entity;
use App\Entity\Traits\EntityTimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
{
    use EntityTimestampableTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zc;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;
    /**
     * @ORM\Column(type="boolean")
     */
    private $isDefault;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="addresses")
     */
    private $host;
    public function __construct()
    {
        $this->isDefault = true;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getStreet(): ?string
    {
        return $this->street;
    }
    public function setStreet(string $street): self
    {
        $this->street = $street;
        return $this;
    }
    public function getZc(): ?string
    {
        return $this->zc;
    }
    public function setZc(string $zc): self
    {
        $this->zc = $zc;
        return $this;
    }
    public function getCity(): ?string
    {
        return $this->city;
    }
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }
    public function getCountry(): ?string
    {
        return $this->country;
    }
    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }
    public function getIsDefault(): ?bool
    {
        return $this->isDefault;
    }
    public function setIsDefault(bool $isDefault): self
    {
        $this->isDefault = $isDefault;
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
}
