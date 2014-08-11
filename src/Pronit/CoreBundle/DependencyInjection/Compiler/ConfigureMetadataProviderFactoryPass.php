<?php

namespace Pronit\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 *
 * @author ldelia
 */
class ConfigureMetadataProviderFactoryPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('bluegrass.metadata_provider_factory'))
        {            
            $container->getDefinition('bluegrass.metadata_provider_factory')->addMethodCall('setMetadataProviderFactoryLocator', array( new Reference("pronit_core.tablacondicion_metadata_provider_factory_locator") ));
        }
        
    }    
}
