<?php

namespace App\Homework;

use SymfonySkillbox\SymfonySkillboxHomeworkBundle\StrategyInterface;
use SymfonySkillbox\SymfonySkillboxHomeworkBundle\Unit;

class BillGatesStrategy implements StrategyInterface
{

    public function next(array $units, int $resource): ?Unit
    {
        if ($this->expensiveUnit($units, $resource) === null) {
            return null;
        }
        return $this->expensiveUnit($units, $resource);
    }

    private function expensiveUnit(array $units, int $resource): ?Unit
    {
        $maxCost = null;
        $key = null;
        $max = null;
        /**
         * @var  $unit Unit|null
         */
        foreach ($units as $k => $unit) {
            if ($resource >= $unit->getCost()) {
                if ($unit->getCost() > $maxCost || $maxCost === null) {
                    $maxCost = $unit->getCost();
                    $key = $k;
                }
                $max = $units[$key];
            }
        }

        return $max;
    }

}