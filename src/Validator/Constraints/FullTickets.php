<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FullTickets extends Constraint
{
    public $message = "Le nombre maximum de visiteur pour ce jour est atteint, il est donc impossible de terminer votre commande.";
}
