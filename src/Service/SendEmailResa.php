<?php
namespace App\Service;

class SendEmailResa
{

    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * Undocumented function
     *
     * @param array $resa
     * @return void
     */
    public function postMail($resa)
    {

        $message = (new \Swift_Message('Votre Réservation n° ' . $resa->getCodeResa()))
            ->setFrom('louvre@musee.fr')
            ->setTo($resa->getEmailResa())
            ->setBody(
                $this->twig->render('resa/emails.html.twig', [
                    'resa' => $resa
                ]),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
