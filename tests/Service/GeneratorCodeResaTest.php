<?php
namespace App\tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\GeneratorCodeResa;

class GeneratorCodeResaTest extends WebTestCase
{
    public function TestGeneratorCode()
    {
        $generatorCodeResa = new GeneratorCodeResa();
        $result = $generatorCodeResa->generateCode();
        $this->assertEquals('', $result);
    }
}
