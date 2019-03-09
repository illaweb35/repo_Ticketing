<?php
namespace App\Validator\Constraints;

use App\Entity\Resa;
use App\Validator\Constraints\FullTickets;
use Symfony\Component\Validator\Constraint;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class FullTicketsValidator extends ConstraintValidator
{
    protected $manager;
    protected $request;
    /*
     * Call constructor
     *
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager, RequestStack $request)
    {
        $this->request = $request;
        $this->manager = $manager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof FullTickets) {
            throw new UnexpectedTypeException($constraint, FullTickets::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        if (!is_integer($value)) {
            throw new UnexpectedValueException($value, 'integer');
        }
        // Get current request
        $request = $this->request->getCurrentRequest();
        $resa = $request->request->get('resa');

        // Get the current Resa date input
        $dateResa = new \DateTime($resa['visitDate']);

        // Get all Resa entities by current date input
        $countTickets = (int)$this->manager->getRepository(Resa::class)->findTicketsByDate($dateResa);
        $dayTickets = $resa['nbTickets'] + $countTickets;

        if ($dayTickets >= 1000) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
