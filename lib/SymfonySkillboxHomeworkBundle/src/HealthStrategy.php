<?php

namespace SymfonySkillbox\SymfonySkillboxHomeworkBundle;

class HealthStrategy implements StrategyInterface
{

    public function next(array $units, int $resource): ?Unit
    {
        if($this->maxHPUnit($units,$resource) === null){
            return null;
        }
        return  $this->maxHPUnit($units,$resource);
    }

    private function maxHPUnit(array $units, int $resource): ?Unit
    {
        $maxHP = null;
        $maxKey = null;
        $hp = null;
        /**
         * @var  $unit Unit|null
         */
        foreach ($units as $k => $unit) {
            if ($resource >= $unit->getCost()){
                if ($unit->getHealth() > $maxHP || $maxHP === null) {
                    $maxHP = $unit->getHealth();
                    $maxKey = $k;
                }
                $hp=$units[$maxKey];
            }
        }
        return $hp;
    }

}