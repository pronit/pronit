<?php

namespace Pronit\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Pronit\CoreBundle\DependencyInjection\Compiler\ConfigureMetadataProviderFactoryPass;


class PronitCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ConfigureMetadataProviderFactoryPass());
    }    
}
