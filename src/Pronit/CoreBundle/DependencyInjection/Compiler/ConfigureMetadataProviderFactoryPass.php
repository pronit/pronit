<?php

namespace Pronit\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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
            
//            $container->getDefinition('bluegrass.metadata_provider_factory')->addMethodCall('setProvider', array( '\Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion', '\Pronit\CoreBundle\Metadata\TablaCondicionMetadataProvider' ));
        }
    }    
}
