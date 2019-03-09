<?php
namespace App\Service;

class Holidays
{

    /**
     * Calculation of vacation dates
     *
     * @param \DateTime $value
     *
     * @return array
     */
    public function getHolidays(\DateTime $value): array
    {

        $year               = $value->format('Y');
        $easterDayTimeStamp = (easter_date($year));
        $easterDateTime     = new \DateTime("@$easterDayTimeStamp");
        // Pâques
        $easterDay          = $easterDateTime->format('D d M Y');
        // Lundi de Pâques
        $easterMonday       = new \DateTime($easterDay . '+1day');
        // Ascension
        $ascension          = new \DateTime($easterDay . '+40 days');
        // Pentecôte
        $pentecote          = new \DateTime($easterDay . '+51 days');
        // Victoire des Alliées
        $victory            = date('D d M Y', mktime(0, 0, 0, 5, 8, $year));
        // Assomption
        $assomption         = date('D d M Y', mktime(0, 0, 0, 8, 15, $year));
        // Armistice
        $armistice          = date('D d M Y', mktime(0, 0, 0, 11, 11, $year));

        $allHolidays = [
            $easterDay,
            $easterMonday   = $easterMonday->format('D d M Y'),
            $victory,
            $ascension      = $ascension->format('D d M Y'),
            $pentecote      = $pentecote->format('D d M Y'),
            $assomption,
            $armistice
        ];
        return $allHolidays;
    }

    /**
     * Museum closing days
     *
     * @param \DateTime $value
     *
     * @return array
     */
    public function dayOff(\DateTime $value): array
    {
        $year           = $value->format('Y');
        //Nouvel An
        $newYear        = date('D d M Y', mktime(0, 0, 0, 1, 1, $year));
        // Fête du travail
        $laborDay       = date('D d M Y', mktime(0, 0, 0, 5, 01, $year));
        // Fête nationnale
        $nationnalDay   = date('D d M Y', mktime(0, 0, 0, 7, 14, $year));
        // Toussaint
        $allSaints      = date('D d M Y', mktime(0, 0, 0, 11, 1, $year));
        // Noêl
        $christmas      = date('D d M Y', mktime(0, 0, 0, 12, 25, $year));

        $daysOff = [
            $newYear,
            $laborDay,
            $nationnalDay,
            $allSaints,
            $christmas
        ];
        return $daysOff;
    }
}
