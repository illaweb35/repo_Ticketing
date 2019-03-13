<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\CalculateHolidays;

class HomeControllerTest extends WebTestCase
{

    /**
    * @test
    *
    * @param url $url
    * @dataProvider urlProvider
    */
    public function index($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        yield ['/'];
    }

    /**
     * @test
     *
     * @param CalculateHolidays $holidays
     * @return void
     * @dataProvider dataHolidays
     */
    public function infos($testHolidays)
    {
        $holiday = new CalculateHolidays();

        $year = new \Datetime();
        $daysOff = $holiday->dayOff($year);
        $holidays = $holiday->getHolidays($year);

        $this->assertSame($testHolidays, $daysOff);
    }
    public function dataHolidays()
    {
        $year = new \Datetime();
        return array(
            [mktime(0, 0, 0, 1, 1, $year)],
            [mktime(0, 0, 0, 5, 1, $year)],
            [mktime(0, 0, 0, 07, 14, $year)],
            [mktime(0, 0, 0, 11, 1, $year)],
            [mktime(0, 0, 0, 12, 25, $year)]
        );
    }
}
