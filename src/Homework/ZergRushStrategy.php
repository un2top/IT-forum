<?php

namespace App\Homework;

use SymfonySkillbox\SymfonySkillboxHomeworkBundle\StrategyInterface;
use SymfonySkillbox\SymfonySkillboxHomeworkBundle\Unit;

class ZergRushStrategy implements StrategyInterface
{

    public function next(array $units, int $resource): ?Unit
    {
        if ($this->zergUnit($units, $resource) === null) {
            return null;
        }
        return $this->zergUnit($units, $resource);
    }

    private function zergUnit(array $units, int $resource): ?Unit
    {
        $minCost = null;
        $key = null;
        $min = null;
        /**
         * @var  $unit Unit|null
         */
        foreach ($units as $k => $unit) {
            if ($resource >= $unit->getCost()) {
                if ($unit->getCost() < $minCost || $minCost === null) {
                    $minCost = $unit->getCost();
                    $key = $k;
                }
                $min = $units[$key];
            }
        }

        return $min;
    }

}