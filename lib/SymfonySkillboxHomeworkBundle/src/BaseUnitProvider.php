<?php

namespace SymfonySkillbox\SymfonySkillboxHomeworkBundle;

class BaseUnitProvider implements UnitProviderInterface
{

    public function getUnits(): array
    {
        $units =
            [
            new Unit('Крестьянин', 33, 1, 1),
            new Unit('Солдат', 100, 5, 100),
            new Unit('Лучник', 150, 6, 50),
            ]
        ;

        return $units;

    }

}
