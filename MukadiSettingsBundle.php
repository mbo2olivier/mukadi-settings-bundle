<?php

namespace Mukadi\SettingsBundle;

use Mukadi\SettingsBundle\Compiler\TypesCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MukadiSettingsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new TypesCompilerPass());
    }

}
