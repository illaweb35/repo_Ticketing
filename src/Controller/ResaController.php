<?php

namespace App\Controller;

use App\Entity\Resa;
use App\Form\ResaType;
use App\Service\GeneratorCodeResa;
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
            $resa->setResaCode($code->generatorCode());

            // Persist the info and save in session
            $this->manager->persist($resa);
            $this->session->set('resa', $resa);

            return $this->redirectToRoute('ticket_new');
        }
        return $this->render('resa/newResa.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
