<?php

namespace Pronit\CoreBundle\DataFixtures\ORM\PlanificacionProduccion;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteExterno;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\ComponenteInterno;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\Operacion;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\CoreBundle\Entity\PlanificacionProduccion\ListaMateriales;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\Componente;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\VersionFabricacion;
use Pronit\CoreBundle\Entity\PlanificacionProduccion\HojaRuta;

/**
 * @author ldelia
 */
class LoadPlanificacionProduccion extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;    
    private $manager;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function getManager()
    {
        return $this->manager;
    }

    public function setManager(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    
    /**
     * {@inheritDoc}
     */       
    public function load(ObjectManager $manager)
    {
        $this->setManager($manager);

        /**
         * Se define lista de materiales
         */
        $valuesListaMateriales =  array(
            array(
                "material" => "INTEL-i5-6200U",
                "componentesExternos" => array(
                    array( "cantidad" => 1, "material" => "INTEL-Graphics-520" ),
                ),
                "componentesInternos" => array(

                )
            ),
            array( 
                "material" => "R5-471T",
                "componentesExternos" => array(
                    array( "cantidad" => 2, "material" => "RAM-4GB" ),
                ),
                "componentesInternos" => array(
                    array( "cantidad" => 1, "versionFabricacion" => "INTEL-i5-6200U Tierra del Fuego" ),
                )
            ),
        );

        /**
         * Primero se crea las listas de materiales y sus componentes externos
         */
        
        foreach( $valuesListaMateriales as $value ){
            
            $obj = new ListaMateriales();
            $obj->setMaterial( $this->getReference('pronit-gestionbienesyservicios-bienservicio-' . $value['material'] ) );

            foreach ($value['componentesExternos'] as $componenteExternoValue ){
                $componente = new ComponenteExterno();
                $componente->setCantidad( $componenteExternoValue[ 'cantidad' ] );
                $componente->setMaterial( $this->getReference( 'pronit-gestionbienesyservicios-bienservicio-' . $componenteExternoValue[ 'material' ] ) );
                $obj->addComponente( $componente );
            }

            $this->addReference('pronit-core-planificacionproduccion-listamateriales-' . $value['material'], $obj);
        }

        $this->loadHojaRuta();

        $this->loadVersionFabricacion();


        /**
         * Luego que se crean las versiones de fabricacion, se pueden crear los componentes internos
         */

        foreach( $valuesListaMateriales as $value ){

            $obj = $this->getReference('pronit-core-planificacionproduccion-listamateriales-' . $value['material']);

            foreach ($value['componentesInternos'] as $componenteInternoValue ){
                $componente = new ComponenteInterno();
                $componente->setCantidad( $componenteInternoValue[ 'cantidad' ] );
                $componente->setVersionFabricacion( $this->getReference( 'pronit-core-planificacionproduccion-versionfabricacion-' . $componenteInternoValue[ 'versionFabricacion' ] ) );
                $obj->addComponente( $componente );
            }

            $manager->persist($obj);
        }

        $manager->flush();
    }

    protected function loadHojaRuta()
    {
        /*
         * Se define una hoja de ruta y operaciones
         */

        $hojaRuta = new HojaRuta();
        $hojaRuta->setNombre("Proceso de Fabricación de Procesador");
        $hojaRuta->addOperacion(  (new Operacion())->setOrden(1)->setDescripcion("Paso 1 Fabricación Procesador")->setCantidad(2)->setTiempo(100) );
        $hojaRuta->addOperacion(  (new Operacion())->setOrden(2)->setDescripcion("Paso 2 Fabricación Procesador")->setCantidad(2)->setTiempo(100) );
        $hojaRuta->addOperacion(  (new Operacion())->setOrden(3)->setDescripcion("Ensamblar")->setCantidad(2)->setTiempo(300) );

        $this->setReference('pronit-core-planificacionproduccion-hojaruta-fabricacionprocesador', $hojaRuta);
        $this->getManager()->persist($hojaRuta);


        $hojaRuta = new HojaRuta();
        $hojaRuta->setNombre("Proceso de Fabricación de Laptop");
        $hojaRuta->addOperacion(  (new Operacion())->setOrden(1)->setDescripcion("Paso 1 Fabricación Laptop")->setCantidad(2)->setTiempo(100) );
        $hojaRuta->addOperacion(  (new Operacion())->setOrden(2)->setDescripcion("Ensamblar")->setCantidad(2)->setTiempo(300) );

        $this->setReference('pronit-core-planificacionproduccion-hojaruta-fabricacionlaptop', $hojaRuta);
        $this->getManager()->persist($hojaRuta);

    }

    protected function loadVersionFabricacion()
    {
        /**
         * Se define una versión de fabricación con una lista de materiales para una hoja de ruta
         */
        $versionFabricacion = new VersionFabricacion();
        $versionFabricacion->setNombre( "INTEL-i5-6200U Tierra del Fuego" );
        $versionFabricacion->setListaMateriales( $this->getReference('pronit-core-planificacionproduccion-listamateriales-INTEL-i5-6200U') );
        $versionFabricacion->setHojaRuta( $this->getReference('pronit-core-planificacionproduccion-hojaruta-fabricacionprocesador') );

        $this->setReference('pronit-core-planificacionproduccion-versionfabricacion-INTEL-i5-6200U Tierra del Fuego', $versionFabricacion);
        $this->getManager()->persist($versionFabricacion);

        $versionFabricacion = new VersionFabricacion();
        $versionFabricacion->setNombre( "R5-471T Tierra del Fuego" );
        $versionFabricacion->setListaMateriales( $this->getReference('pronit-core-planificacionproduccion-listamateriales-R5-471T') );
        $versionFabricacion->setHojaRuta( $this->getReference('pronit-core-planificacionproduccion-hojaruta-fabricacionlaptop') );
        $this->setReference('pronit-core-planificacionproduccion-versionfabricacion-R5-471T Tierra del Fuego', $versionFabricacion);
        $this->getManager()->persist($versionFabricacion);
    }
    
    function getOrder()
    {
        return 90;
    }
}
