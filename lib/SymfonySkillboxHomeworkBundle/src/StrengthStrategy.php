<?php

namespace SymfonySkillbox\SymfonySkillboxHomeworkBundle;

class StrengthStrategy implements StrategyInterface
{

    public function next(array $units, int $resource): ?Unit
    {
        if($this->strengthUnit($units,$resource) === null){
            return null;
        }
       return  $this->strengthUnit($units,$resource);
    }

    private function strengthUnit(array $units, int $resource): ?Unit
    {
        $maxStr = null;
        $maxKey = null;
        $str = null;
        /**
         * @var  $unit Unit|null
         */
        foreach ($units as $k => $unit) {
            if ($resource >= $unit->getCost()){
                if ($unit->getStrength() > $maxStr || $maxStr === null) {
                    $maxStr = $unit->getStrength();
                    $maxKey = $k;
                }
                $str=$units[$maxKey];
            }
        }
        return $str;
    }

}