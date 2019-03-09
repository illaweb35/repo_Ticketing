<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class HalfDay extends Constraint
{
    public $message = "Passez 14 Heures vous ne pouvez plus commander de billets Journée , merci de sélectionner \"Demi-Journée\" et re-valider la commande. ";
}
