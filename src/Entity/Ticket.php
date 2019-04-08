<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de saisir votre nom de famille !")
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Votre nom de famille doit comporter au moins {{ limit }} caractères.",
     *      maxMessage = "Votre nom de famille ne peut pas contenir plus de {{ limit }} caractères")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Merci de saisir un prénom !")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Votre prénom doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Votre prénom ne peut pas contenir plus de {{ limit }} caractères")
     */
    private $firstName;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message = "Merci de saisir votre date de naissance !")
     * @Assert\Date
     * @Assert\Range(
     *      min = "-115 years",
     *      max = "today", minMessage="Vous avez plus de 115 ans !!!",maxMessage="Vous vous interresz déjà à la culture !!!")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Country
     */
    private $country;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reducePrice;

    /**
     * @ORM\Column(type="float")
     */
    private $priceTicket;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Resa", inversedBy="tickets",cascade={"persist"})
     */
    private $resa;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ageClient;

    /**
     * Callback called every time we create a reservation
     * @ORM\PrePersist
     * @return void
     */
    public function prePersist()
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new \Datetime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

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

    public function getReducePrice(): ?bool
    {
        return $this->reducePrice;
    }

    public function setReducePrice(bool $reducePrice): self
    {
        $this->reducePrice = $reducePrice;

        return $this;
    }

    public function getPriceTicket(): ?float
    {
        return $this->priceTicket;
    }

    public function setPriceTicket(float $priceTicket): self
    {
        $this->priceTicket = $priceTicket;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getResa(): ?Resa
    {
        return $this->resa;
    }

    public function setResa(?Resa $resa): self
    {
        $this->resa = $resa;

        return $this;
    }

    public function getAgeClient(): ?int
    {
        return $this->ageClient;
    }

    public function setAgeClient(?int $ageClient): self
    {
        $this->ageClient = $ageClient;

        return $this;
    }
}
