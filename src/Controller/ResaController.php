<?php

namespace App\Controller;

use App\Entity\Resa;
use App\Entity\Ticket;
use App\Form\ResaType;
use App\Service\Checkout;
use App\Service\AgeCalculator;
use App\Service\SendEmailResa;
use App\Service\GeneratorCodeResa;
use App\Form\CollectionTicketsType;
use App\Service\CalculateTicketPrice;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ResaController
 *
 * @Route("/{_locale}", requirements={"_locale" ="|fr|en|de|es"})
 */
class ResaController extends AbstractController
{
    private $session;
    private $manager;

    public function __construct(SessionInterface $session, ObjectManager $manager)
    {
        $this->session = $session;
        $this->manager = $manager;
    }

    /**
     * Verification of the current session
     *
     * @return Response
     */
    public function verifSession()
    {
        // Verification of the current session otherwise error
        if (!$this->session->has('resa')) {
            $this->addFlash('danger', "An error has occurred, thank you to renew your request !");
            return $this->redirectToRoute('resa_new');
        }
        $resaSession = $this->session->get('resa');
        return $resaSession;
    }
    /**
     * Empty session
     *
     * @Route("/invalidate_session",name="cancel_session")
     * @return Response
     */
    public function cancelResa()
    {
        $this->session->remove('resa');
        return $this->redirectToRoute('resa_new');
    }

    /**
     * Creation & management of reservations
     *
     * @Route("/resa/new", name="resa_new")
     *
     * @param Request $request
     * @return Response
     */
    public function newResa(Request $request)
    {
        // Check if the session is existing, otherwise create the session
        if (!$this->session->has('resa')) {
            $resa = new Resa();
        } else {
            $resa = $this->session->get('resa');
        }
        // Reservation Form
        $form = $this->createForm(ResaType::class, $resa);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $code = new GeneratorCodeResa();
            $resa->setCodeResa($code->generatorCode());

            // Persist the info and save in session
            $this->manager->persist($resa);
            $this->session->set('resa', $resa);

            return $this->redirectToRoute('ticket_new');
        }
        return $this->render('resa/newResa.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * Creation & management of Tickets
     *
     * @Route("/ticket/new", name="ticket_new")
     *
     * @param Request $request
     * @return Response
     */
    public function newTicket(AgeCalculator $calculateAge, CalculateTicketPrice $ticketPrices, Request $request)
    {
        $resa = $this->verifSession();

        // recovering the number of tickets requested
        $tickets = $resa->getTickets();
        $nbTickets = $resa->getNbTickets();

        // check if the tickets have not already been created, otherwise creation
        if ($resa->getTickets()->count() !== $nbTickets) {
            for ($i = 0; $i <= $nbTickets - 1; $i++) {
                $ticket = new Ticket();
                $resa->addTicket($ticket);
            }
        }
        // Tickets Form
        $form = $this->createForm(CollectionTicketsType::class, $resa);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Initialization of the Reservation Amount
            $totalPrice = 0;

            // For each ticket generated, calculate the ticket price according to the age entered
            foreach ($tickets as $ticket) {
                //Records the age of the customer following the date of birth
                $age = $calculateAge->ageOlder($ticket->getBirthday());
                $ticket->setAgeClient($age);
                //Caculating price of ticket following the age.
                $ticketPrice = $ticketPrices->calculatePrice($ticket->getReducePrice(), $ticket->getBirthday());
                $ticket->setPriceTicket($ticketPrice);
                //Caculating total price for resa
                $totalPrice += $ticketPrice;
                $this->manager->persist($ticket);
            }
            // Records the amount of the reservation
            $resa->setAmountResa($totalPrice);

            // Persist the info and save in session
            $this->manager->persist($resa);
            $this->session->set('resa', $resa);

            return $this->redirectToRoute('resa_verif');
        }
        return $this->render('resa/newTicket.html.twig', [
            'form' => $form->createView(),
            'resa' => $resa

        ]);
    }
    /**
     * Summary of the order and sent to checkout
     *
     * @Route("/resa/verif",name="resa_verif")
     *
     * @return Response
     */
    public function resaVerif(Request $request)
    {
        $resa = $this->verifSession();

        return $this->render('resa/verif.html.twig', [
            'resa' => $resa,
        ]);
    }

    /**
     * Save Stripe Charge and send tickets by email
     *
     * @Route("/resa/charge",name="resa_charge")
     *
     * @param Request $request
     * @param Checkout $checkout
     * @param SendEmailResa $sendResa
     * @return void
     */
    public function charge(Request $request, Checkout $checkout, SendEmailResa $sendResa)
    {
        $resa = $this->verifSession();

        //Recovery of the amount of the reservation
        $amount = $resa->getAmountResa() * 100;
        //Passing of the reservation number as description
        $description = 'résa n°:' . $resa->getCodeResa();
        //Sending data to checkout
        $payment = $checkout->checkoutStripe($amount, $description);


        // Stripe token recovery and load passage
        if (!$payment == false) {
            $resa->setPaymentTokenStripe($_POST['stripeToken']);

            // Persist the info and save in session
            $this->manager->persist($resa);
            $this->manager->flush();

            try {
                // Send email
                $sendResa->postMail($resa);

                // Message success
                $this->addFlash('success', 'Votre paiement a bien été validé, Vos billets pour une visite programmée le ' . date_format($resa->getVisitDate(), "d-M-Y") . ' ont été envoyé à l\'adresse mail:  ' . $resa->getEmailResa() . ' sous la référence n° ( ' . $resa->getCodeResa() . ' ) ,  merci de votre commande.');
                $this->cancelResa();
                return $this->redirectToRoute('home_page');
            } catch (\Exception $e) {
                throw new \Exception('warning', 'une erreur est survenue lors de l\'envoi de l\'e-mail, veuillez contacter le musée du Louvre et indiquer votre numéro de réservation suivant: ' . $resa->getCodeResa() . ' , afin de justifier l\'achat de vos billets. Merci de votre compréhension');
            }
        } else {
            // Message error in transaction
            $this->addFlash('danger', "Une erreur de paiement est survenue ! Merci de renouveller votre paiement en vérifiant bien vos éléments bancaire. !");
            return $this->redirectToRoute('resa_verif');
        }

        return $this->render('resa/verif.html.twig');
    }
}
