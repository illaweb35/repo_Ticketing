<?php
namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\GeneratorCodeResa;

class GeneratorCodeResaTest extends WebTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function GeneratorCode()
    {
        $generatorCodeResa = new GeneratorCodeResa();

        $result = $generatorCodeResa->generatorCode();

        $this->assertSame('e2i3uOzdff8', $result);
    }
}
