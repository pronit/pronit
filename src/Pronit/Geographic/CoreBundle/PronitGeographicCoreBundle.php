<?php

namespace Pronit\Geographic\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Pronit\Geographic\CoreBundle\DependencyInjection\Compiler\ConfigureMetadataProviderFactoryPass;

class PronitGeographicCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ConfigureMetadataProviderFactoryPass());
    }    
}
