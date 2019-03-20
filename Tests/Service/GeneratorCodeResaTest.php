<?php
namespace App\Tests\Service;


use PHPUnit\Framework\TestCase;
use App\Service\GeneratorCodeResa;


class GeneratorCodeResaTest extends TestCase
{

    public function testGeneratorCode()
    {
        $generatorCodeResa = new GeneratorCodeResa();

        $result = $generatorCodeResa->generatorCode();
    }
}
