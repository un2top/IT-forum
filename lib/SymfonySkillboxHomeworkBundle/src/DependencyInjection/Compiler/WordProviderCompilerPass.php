<?php

namespace SymfonySkillbox\SymfonySkillboxHomeworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class WordProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        $definition = $container->getDefinition('symfony_skillbox_homework.unit_factory');
        $references = [];
        foreach ($container->findTaggedServiceIds('symfony_skillbox_homework.unit_provider') as $id => $tags) {
            $references[] = new Reference($id);
        }
        $definition->setArgument(1, $references);
    }


}
