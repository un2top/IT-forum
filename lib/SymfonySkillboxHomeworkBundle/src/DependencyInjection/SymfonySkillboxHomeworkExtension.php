<?php

namespace SymfonySkillbox\SymfonySkillboxHomeworkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use SymfonySkillbox\SymfonySkillboxHomeworkBundle\UnitProviderInterface;

class SymfonySkillboxHomeworkExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('symfony_skillbox_homework.unit_factory');

        $definition->setArgument(0, new Reference($config['strategy']));

        $container->registerForAutoconfiguration(UnitProviderInterface::class)
            ->addTag('symfony_skillbox_homework.unit_provider');

    }

    public function getAlias()
    {
        return 'symfony_skillbox_homework';
    }

}