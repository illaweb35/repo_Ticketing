<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResaRepository")
 */
class Resa
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeResa;

    /**
     * @ORM\Column(type="datetime")
     */
    private $visitDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $typeTicket;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbTickets;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emailResa;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amountResa;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paymentTokenStripe;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="resa")
     */
    private $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeResa(): ?string
    {
        return $this->codeResa;
    }

    public function setCodeResa(string $codeResa): self
    {
        $this->codeResa = $codeResa;

        return $this;
    }

    public function getVisitDate(): ?\DateTimeInterface
    {
        return $this->visitDate;
    }

    public function setVisitDate(\DateTimeInterface $visitDate): self
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    public function getTypeTicket(): ?bool
    {
        return $this->typeTicket;
    }

    public function setTypeTicket(bool $typeTicket): self
    {
        $this->typeTicket = $typeTicket;

        return $this;
    }

    public function getNbTickets(): ?int
    {
        return $this->nbTickets;
    }

    public function setNbTickets(int $nbTickets): self
    {
        $this->nbTickets = $nbTickets;

        return $this;
    }

    public function getEmailResa(): ?string
    {
        return $this->emailResa;
    }

    public function setEmailResa(string $emailResa): self
    {
        $this->emailResa = $emailResa;

        return $this;
    }

    public function getAmountResa(): ?float
    {
        return $this->amountResa;
    }

    public function setAmountResa(?float $amountResa): self
    {
        $this->amountResa = $amountResa;

        return $this;
    }

    public function getPaymentTokenStripe(): ?string
    {
        return $this->paymentTokenStripe;
    }

    public function setPaymentTokenStripe(?string $paymentTokenStripe): self
    {
        $this->paymentTokenStripe = $paymentTokenStripe;

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

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setResa($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getResa() === $this) {
                $ticket->setResa(null);
            }
        }

        return $this;
    }
}
