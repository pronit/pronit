<?php

namespace Pronit\EstructuraEmpresaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\EstructuraEmpresaBundle\Entity\SociedadCO;
use Pronit\EstructuraEmpresaBundle\Entity\SociedadGL;
use Pronit\EstructuraEmpresaBundle\Entity\SociedadFI;
use Pronit\EstructuraEmpresaBundle\Entity\CentroLogistico;
use Pronit\EstructuraEmpresaBundle\Entity\Almacen;

/**
 * @author ldelia
 */
class LoadSociedades extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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

        /************** SOCIEDAD CO ***************/
        $sociedadCO =  array(
            array( 
                "nombre" => "Ramirez y Asoc. Holding", 
                "abreviatura" => "Ramirez Holding", 
                "nombreFantasia" => "Ramirez Holding",
                "activa" => true,
                "fechaFundacion" => new \DateTime('1982-02-27'),
            ),
        );        
        
        foreach( $sociedadCO as $sco ){
            $co_obj = new SociedadCO(); 
            $co_obj->setNombre( $sco['nombre'] );
            $co_obj->setAbreviatura( $sco['abreviatura'] );
            $co_obj->setNombreFantasia( $sco['nombreFantasia'] );
            $co_obj->setFechaFundacion( $sco['fechaFundacion'] );
            $co_obj->setActiva( $sco['activa'] );        
            
            $this->addReference('pronit-estructuraempresa-sociedad-co-ramirez-holding', $co_obj);                
            
            $manager->persist($co_obj);            
        }
        
        /************** SOCIEDAD GL ***************/
        $sociedadGL =  array(
            array( 
                "sociedadCO" => "ramirez-holding",
                "nombre" => "Ramirez Argentina", 
                "abreviatura" => "Ramirez Arg", 
                "nombreFantasia" => "Ramirez Argentina",
                "activa" => true,
                "fechaFundacion" => new \DateTime('1982-02-27'),
            ),
        );        
        
        foreach( $sociedadGL as $sgl ){
            $gl_obj = new SociedadGL(); 
            $gl_obj->setSociedadCO( $this->getReference('pronit-estructuraempresa-sociedad-co-'. $sgl['sociedadCO']) );
            $gl_obj->setNombre( $sgl['nombre'] );
            $gl_obj->setAbreviatura( $sgl['abreviatura'] );
            $gl_obj->setNombreFantasia( $sgl['nombreFantasia'] );
            $gl_obj->setFechaFundacion( $sgl['fechaFundacion'] );
            $gl_obj->setActiva( $sgl['activa'] );        
            
            $this->addReference('pronit-estructuraempresa-sociedad-gl-ramirez-holding-arg', $gl_obj);                
            
            $manager->persist($gl_obj);            
        }

        /************** SOCIEDAD FI ***************/
        
        $sociedadFI = new SociedadFI();
        $sociedadFI->setSociedadGL( $this->getReference('pronit-estructuraempresa-sociedad-gl-ramirez-holding-arg') );
        $sociedadFI->setNombre( "Modelo SA" );
        $sociedadFI->setAbreviatura("MSA FI");
        $sociedadFI->setNombreFantasia("Modelo SA Fantasía");
        $sociedadFI->setFechaFundacion(new \DateTime());
        $sociedadFI->setActiva(true);        
        
        $centrosData = array( 
            array( 'codigo' => 1000, 
                    'nombre' => 'Casa Matriz', 
                    'divisionAdministrativa' => 'pronit-geographic-distrito federal-capital federal',
                    'almacenes' => array(
                        array('codigo' => 101, 'nombre' => 'Materia Prima', 'divisionAdministrativa' => 'pronit-geographic-distrito federal-capital federal'),
                        array('codigo' => 102, 'nombre' => 'Control de Calidad', 'divisionAdministrativa' => 'pronit-geographic-distrito federal-capital federal'),                        
                        array('codigo' => 103, 'nombre' => 'Exportaciones', 'divisionAdministrativa' => 'pronit-geographic-distrito federal-capital federal'),                        
                    )
                ),
            array( 'codigo' => 2000, 
                    'nombre' => 'Sucursal Bs As', 
                    'divisionAdministrativa' => 'pronit-geographic-provincia-buenos aires',
                    'almacenes' => array(
                        array('codigo' => 201, 'nombre' => 'Materia Prima', 'divisionAdministrativa' => 'pronit-geographic-provincia-buenos aires'),
                        array('codigo' => 202, 'nombre' => 'Producto terminado', 'divisionAdministrativa' => 'pronit-geographic-provincia-buenos aires'),                        
                        array('codigo' => 203, 'nombre' => 'Pañol', 'divisionAdministrativa' => 'pronit-geographic-provincia-buenos aires'),                        
                        array('codigo' => 204, 'nombre' => 'Líneas', 'divisionAdministrativa' => 'pronit-geographic-provincia-buenos aires'),                        
                        array('codigo' => 205, 'nombre' => 'Corte', 'divisionAdministrativa' => 'pronit-geographic-provincia-buenos aires'),                        
                    )                
                ),
            array( 'codigo' => 3000, 
                    'nombre' => 'Sucursal Córdoba', 
                    'divisionAdministrativa' => 'pronit-geographic-provincia-cordoba',
                    'almacenes' => array(
                        array('codigo' => 301, 'nombre' => 'Local de Venta Cordoba Capital', 'divisionAdministrativa' => 'pronit-geographic-departamento-capital'),
                        array('codigo' => 302, 'nombre' => 'Local de Venta Villa Carloz Paz', 'divisionAdministrativa' => 'pronit-geographic-ciudad-villa carlos paz'),                        
                    )                
                ),
        );
        
        foreach( $centrosData as $centroData )
        {
            $centroLogistico = new CentroLogistico();
            $centroLogistico->setCodigo($centroData['codigo']);
            $centroLogistico->setNombre($centroData['nombre']);
            $centroLogistico->setDivisionAdministrativa( $this->getReference( $centroData['divisionAdministrativa'] ) );
            
            foreach( $centroData['almacenes'] as $almacenData )
            {
                $almacen = new Almacen();
                $almacen->setCodigo( $almacenData['codigo'] );
                $almacen->setNombre( $almacenData['nombre'] );
                $almacen->setDivisionAdministrativa( $this->getReference( $almacenData['divisionAdministrativa'] ) );
                
                $centroLogistico->addAlmacen($almacen);
            }
            
            $this->addReference('pronit-estructuraempresa-centroLogistico-' . $centroData['codigo'], $centroLogistico);                
            
            $sociedadFI->addCentroLogistico($centroLogistico);            
        }
        
        $manager->persist($sociedadFI);

        $this->addReference('pronit-estructuraempresa-sociedadfi', $sociedadFI);                
                
        /***************** sociedadFI extras ***********/
        
        $sociedadFI =  array(
            array( 
                "sociedadGL" => "ramirez-holding-arg",
                "nombre" => "NH Construcciones S.A.", 
                "abreviatura" => "NH S.A.", 
                "nombreFantasia" => "NH Construcciones S.A.",
                "activa" => true,
                "fechaFundacion" => new \DateTime('1984-06-27'),
            ),
        );        
        
        foreach( $sociedadFI as $sfi ){
            $fi_obj = new SociedadFI(); 
            $fi_obj->setSociedadGL( $this->getReference('pronit-estructuraempresa-sociedad-gl-'. $sfi['sociedadGL']) );
            $fi_obj->setNombre( $sfi['nombre'] );
            $fi_obj->setAbreviatura( $sfi['abreviatura'] );
            $fi_obj->setNombreFantasia( $sfi['nombreFantasia'] );
            $fi_obj->setFechaFundacion( $sfi['fechaFundacion'] );
            $fi_obj->setActiva( $sfi['activa'] );        
            
            $manager->persist($fi_obj);            
        }
        
        
        
        $manager->flush();        
    }
    
    function getOrder()
    {
        return 30; 
    }
}
