<?php

namespace SymfonySkillbox\SymfonySkillboxHomeworkBundle;

class UnitFactory
{

    /**
     * @param StrategyInterface $strategy
     * @param UnitProviderInterface[] $unitProviders
     */

    public function __construct(StrategyInterface $strategy, iterable $unitProviders)
    {
        $this->strategy = $strategy;
        $this->unitProviders = $unitProviders;
    }

    /**
     * Производит армию
     *
     * @param int $resources
     * @return Unit[]
     */
    public function produceUnits(int $resources): array
    {
        $allUnits = [];
        foreach ($this->unitProviders as $unit) {
            $allUnits[] = $unit->getUnits();
        }
        $allUnits = call_user_func_array('array_merge', $allUnits);

        $youArmy = [];
        while ($unit = $this->strategy->next($allUnits, $resources)) {
            $youArmy[] = $unit;
            $resources -= $unit->getCost();
        }
        return [$youArmy, $resources];
    }

}
