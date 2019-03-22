<?php
namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\AgeCalculator;

class AgeCalculatorTest extends TestCase
{

    /**
     * Undocumented function
     *
     * @param \DateTime $birthday
     *
     * @dataProvider birthday
     */
    public function testAgeOlder(\DateTime $birthday)
    {
        $today = new \DateTime();
        $data = $today->diff($birthday, true)->y;
        $age = new AgeCalculator();
        $this->assertEquals($data, $age->ageOlder($birthday));
    }

    public function birthday()
    {
        return [
            [new \datetime('1989-03-03')],
            [new \Datetime('2010-01-25')],
            [new \Datetime('1954-12-25')],
            [new \Datetime('1995-07-12')],
            [new \Datetime('2014-02-14')]
        ];
    }
}
