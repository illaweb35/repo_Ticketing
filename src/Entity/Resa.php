<?php

namespace App\Entity;


use App\Entity\Ticket;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Validator\Constraints as AcmeAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResaRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *      "codeResa",
 *      message="Code de réservation inexistant, merci de renouveller la commande")
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
     * @Assert\NotBlank(
     *      message="Merci de choisir une date pour votre prochaine visite au musée du Louvre !")
     * @Assert\Range(
     *      min = "today",
     *      max = "+1 year",
     *      minMessage="La date de visite ne peut pas être antérieure à {{ limit }}.",
     *      maxMessage="Aucun billet ne peut-être acheté pour une date de visite  supérieur à 1 an !")
     * @Assert\NotEqualTo(
     *      "tuesday",
     *      message="Le musée est fermé le mardi.")
     * @AcmeAssert\CloseDays
     */
    private $visitDate;

    /**
     * @ORM\Column(type="boolean")
     * @AcmeAssert\HalfDay
     */
    private $typeTicket = true;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     *      message = "Merci de sélection le nombre de billet que vous souhaité !")
     * @Assert\GreaterThan(
     *      0,
     *      message="La valeur doit être supérieure à 0 !")
     * @Assert\Range(
     *      min=1,
     *      max=10,
     *      minMessage="Vous devez commandez au moins {{ limit }} billet lors de la commande",
     *      maxMessage="Au delà de {{ limit }} billets, merci de contacter le musée pour les tarifs de groupe")
     * @AcmeAssert\FullTickets
     */
    private $nbTickets;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Merci de renseigner votre adresse email !")
     * @Assert\Email()
     */
    private $emailResa;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
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
    public function getId(): ? int
    {
        return $this->id;
    }

    public function getCodeResa(): ? string
    {
        return $this->codeResa;
    }

    public function setCodeResa(string $codeResa): self
    {
        $this->codeResa = $codeResa;

        return $this;
    }

    public function getVisitDate(): ? \DateTimeInterface
    {
        return $this->visitDate;
    }

    public function setVisitDate(\DateTimeInterface $visitDate): self
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    public function getTypeTicket(): ? bool
    {
        return $this->typeTicket;
    }

    public function setTypeTicket(bool $typeTicket): self
    {
        $this->typeTicket = $typeTicket;

        return $this;
    }

    public function getNbTickets(): ? int
    {
        return $this->nbTickets;
    }

    public function setNbTickets(int $nbTickets): self
    {
        $this->nbTickets = $nbTickets;

        return $this;
    }

    public function getEmailResa(): ? string
    {
        return $this->emailResa;
    }

    public function setEmailResa(string $emailResa): self
    {
        $this->emailResa = $emailResa;

        return $this;
    }

    public function getAmountResa(): ? float
    {
        return $this->amountResa;
    }

    public function setAmountResa(? float $amountResa): self
    {
        $this->amountResa = $amountResa;

        return $this;
    }

    public function getPaymentTokenStripe(): ? string
    {
        return $this->paymentTokenStripe;
    }

    public function setPaymentTokenStripe(? string $paymentTokenStripe): self
    {
        $this->paymentTokenStripe = $paymentTokenStripe;

        return $this;
    }

    public function getCreatedAt(): ? \DateTimeInterface
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
