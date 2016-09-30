<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            //new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
			
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            //  NO SE NECESITA EN Sonata 2.3 new Sonata\jQueryBundle\SonatajQueryBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),

            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),            
            new Infinite\FormBundle\InfiniteFormBundle,
            
            new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),
            
            new Bluegrass\Metadata\Bundle\MetadataBundle\BluegrassMetadataBundleMetadataBundle(),
            
            
            new Pronit\CoreBundle\PronitCoreBundle(),
            new Pronit\ParametrizacionGeneralBundle\PronitParametrizacionGeneralBundle(),
            new Pronit\EstructuraEmpresaBundle\PronitEstructuraEmpresaBundle(),
            new Pronit\Geographic\CoreBundle\PronitGeographicCoreBundle(),
            new Pronit\AutomatizacionBundle\PronitAutomatizacionBundle(),
            new Pronit\ComprasBundle\PronitComprasBundle(),
            new Pronit\GestionBienesYServiciosBundle\PronitGestionBienesYServiciosBundle(),
            new Pronit\CustomizingBundle\PronitCustomizingBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            //$bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }

   public function getCacheDir()
    {
        if (in_array($this->environment, array('dev', 'test'))) {
            return '/dev/shm/pronit/cache/' .  $this->environment;
        }

        return parent::getCacheDir();
    }

    public function getLogDir()
    {
        if (in_array($this->environment, array('dev', 'test'))) {
            return '/dev/shm/pronit/logs';
        }

        return parent::getLogDir();
    }    

}
