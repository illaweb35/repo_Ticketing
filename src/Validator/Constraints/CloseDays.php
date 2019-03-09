<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CloseDays extends Constraint
{
    public $message = "Désolé, le musée est fermé les jours fériés suivants: 01/01, 01/11, 25/12 , merci de sélectionner une autre date";
}
