<?php

namespace App\Homework;


use SymfonySkillbox\SymfonySkillboxHomeworkBundle\Unit;
use SymfonySkillbox\SymfonySkillboxHomeworkBundle\UnitProviderInterface;

class LegacyUnitProvider implements UnitProviderInterface
{

    public function getUnits(): array
    {
        $units =
            [
                new Unit('Латник', 200, 11, 300),
                new Unit('Маг', 250, 17, 150),
                new Unit('Дракон', 750, 40, 1250),
            ];

        return $units;

    }

}
