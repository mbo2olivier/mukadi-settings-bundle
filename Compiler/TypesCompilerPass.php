<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 18:43
 */

namespace Mukadi\SettingsBundle\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TypesCompilerPass implements CompilerPassInterface{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if(!$container->has("mukadi_settings.setting")){
            return;
        }
        $def = $container->findDefinition("mukadi_settings.setting");

        $tagged = $container->findTaggedServiceIds("mukadi_settings.setting_type");

        foreach ($tagged as $id => $tags) {
            foreach ($tags as $attr) {
                $def->addMethodCall("addType",array($attr["alias"], new Reference($id)));
            }
        }
    }


} 