<?php
namespace App\Service;

class GeneratorCodeResa
{
    /**
     * Code generation according to today's date and a mix of letters
     *
     * @return String
     */
    public function generatorCode(): string
    {
        $length = 10;
        $letters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $days = new \DateTime();
        $today = $days->format('dmYHis');
        $chaine = $letters . $today;
        $generator = "";

        for ($i = 0; $i <= $length; $i++) {
            $generator .= $chaine[rand() % strlen($chaine)];
        }
        return  $generator;
    }
}
