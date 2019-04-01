<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\CalculateHolidays;

class HomeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = self::createClient();
        $client->request('GET', ("/"));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    /**
     *
     * @dataProvider dataHolidays
     */
    public function testDateOFHolidays($testHolidays)
    {
        $holiday = new CalculateHolidays();

        $year = new \Datetime();
        $daysOff = $holiday->dayOff($year);
        $this->assertContains($testHolidays, $daysOff);
    }
    public function dataHolidays()
    {
        return [
            [date('D d M Y', strtotime('2019-01-01'))],
            [date('D d M Y', strtotime('2019-05-01'))],
            [date('D d M Y', strtotime('2019-07-14'))],
            [date('D d M Y', strtotime('2019-11-01'))],
            [date('D d M Y', strtotime('2019-12-25'))]
        ];
    }
}
