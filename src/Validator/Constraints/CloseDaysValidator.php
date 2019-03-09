<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CloseDaysValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Closedays) {
            throw new UnexpectedTypeException($constraint, CloseDays::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        // Dates of holidays where the museum is closed.
        $closeDays = [
            '0105',
            '1407',
            '0111',
            '2512',
            '0101'
        ];
        // String format
        $dateToString = $value->format('dmY');
        // Deletion of the year
        $visitDate = substr($dateToString, 0, 4);

        // if the chosen date corresponds to the array , there is an error.
        if (in_array($visitDate, $closeDays)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
