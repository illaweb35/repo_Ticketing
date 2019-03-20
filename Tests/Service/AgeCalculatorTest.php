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
     * @param int $data
     * @dataProvider dataAge
     */
    public function testAgeOlder(\DateTime $birthday, $data)
    {

        $age = new AgeCalculator();
        $this->assertEquals($data, $age->ageOlder($birthday));
    }
    public function dataAge()
    {
        return [
            [new \datetime('1990-03-03'), 29],
            [new \Datetime('2010-01-25'), 9],
            [new \Datetime('1954-12-25'), 64],
            [new \Datetime('1995-07-12'), 23],
            [new \Datetime('2014-02-14'), 5]
        ];
    }
}
