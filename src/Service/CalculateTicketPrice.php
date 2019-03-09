<?php
namespace App\Service;

use App\Service\AgeCalculator;

class CalculateTicketPrice
{
    const NORMAL = 16;
    const SENIOR = 12;
    const REDUCE = 10;
    const CHILD = 8;
    const BABY = 0;
    private $ageCalculator;

    public function __construct(AgeCalculator $ageCalculator)
    {
        $this->ageCalculator = $ageCalculator;
    }

    /**
     * Price calculation according to age
     *
     * @param bool $reduce
     * @param \DateTime $birthday
     * @return int
     */
    public function calculatePrice(bool $reduce, \DateTime $birthday): int
    {

        $age = $this->ageCalculator->ageOlder($birthday);
        try {
            if (!$reduce == true && $age >= 60) {
                return self::SENIOR;
            } elseif (!$reduce == true && $age >= 12) {
                return self::NORMAL;
            } elseif (!$reduce == true && $age >= 4) {
                return self::CHILD;
            } elseif (!$reduce == true && $age < 4) {
                return self::BABY;
            } else {
                return self::REDUCE;
            }
        } catch (\Stripe\Error\Card $e) {
            $this->addFlash('danger', "Error in price calculation");
            return $this->redirecToroute('resa_new');
        }
    }
}
