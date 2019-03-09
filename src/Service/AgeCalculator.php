<?php
namespace App\Service;

class AgeCalculator
{
    /**
     * Calculation age following date of birth
     *
     * @param \DateTime $birthday
     * @return int
     */
    public function ageOlder(\DateTime $birthday): int
    {
        $today = new \DateTime();
        $age    = $today->diff($birthday, true)->y;
        return $age;
    }
}
