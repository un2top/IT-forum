<?php

namespace SymfonySkillbox\SymfonySkillboxHomeworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('symfony_skillbox_homework');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->scalarNode('strategy')
                ->defaultValue('symfony_skillbox_homework.strategy_strength')
                ->info('Стратегия производства юнитов (по умолчанию по силе)')
                ->end()
                ->arrayNode('provider')
                ->prototype('scalar')
                ->info('список юнитов')
                ->end()
            ->end();
        return $treeBuilder;

    }

}
