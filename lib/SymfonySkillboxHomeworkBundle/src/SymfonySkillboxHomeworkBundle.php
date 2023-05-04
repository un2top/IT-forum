<?php

namespace SymfonySkillbox\SymfonySkillboxHomeworkBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonySkillbox\SymfonySkillboxHomeworkBundle\DependencyInjection\Compiler\WordProviderCompilerPass;
use SymfonySkillbox\SymfonySkillboxHomeworkBundle\DependencyInjection\SymfonySkillboxHomeworkExtension;

class SymfonySkillboxHomeworkBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new WordProviderCompilerPass());
    }
    protected function createContainerExtension()
    {
        if (null===$this->extension){
            $this->extension = new SymfonySkillboxHomeworkExtension();
        }
        return $this->extension;
    }

}
