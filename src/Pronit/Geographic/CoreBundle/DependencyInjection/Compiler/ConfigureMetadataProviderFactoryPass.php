<?php

namespace Pronit\Geographic\CoreBundle\DependencyInjection\Compiler;

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
        if ($container->hasDefinition('bluegrass.metadata_provider_factory_default_locator'))
        {            
            $container->getDefinition('bluegrass.metadata_provider_factory_default_locator')->addMethodCall('setMetadataProviderFactory', array( '\Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa', new Reference("pronit_geographic.divisionadministrativa_metadata_provider_factory") ));
        }
    }    
}
