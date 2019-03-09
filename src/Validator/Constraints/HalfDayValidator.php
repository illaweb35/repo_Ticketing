<?php
namespace App\Validator\Constraints;

use App\Validator\Constraints\HalfDay;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class HalfDayValidator extends ConstraintValidator
{
    // set the time of the half day
    const setHour = 14;

    protected $request;
    /**
     * Call constructor
     *
     * @param RequestStack $request
     */
    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    /**
    * Verification if 14 hours has passed.
    *
    * @param bool $value
    * @param Constraint $constraint
    */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof HalfDay) {
            throw new UnexpectedTypeException($constraint, HalfDay::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        if (!is_bool($value)) {
            throw new UnexpectedValueException(
                $value,
                'bool'
            );
        }

        // Retrieving the current request
        $request = $this->request->getCurrentRequest();
        $resa = $request->request->get('resa');
        //  Today's date
        $today = date('Y-m-d');
        // Time of the moment
        $hourToday = date('H');
        // Visit Date
        $visitOfDay = $resa['visitDate'];
        // Ticket type of the form
        $todayTypeTicket = $value;

        if ($visitOfDay == $today && $hourToday >= self::setHour && $todayTypeTicket == true) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
