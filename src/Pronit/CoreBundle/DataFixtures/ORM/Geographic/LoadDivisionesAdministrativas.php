<?php

namespace Pronit\CoreBundle\DataFixtures\ORM\Geographic;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa;
use Pronit\ParametrizacionGeneralBundle\Entity\Moneda;


use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\AttributeMetadata;

/**
 * @author ldelia
 */
class LoadDivisionesAdministrativas extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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
        
        $this->loadPaises();
        
        $this->loadComunidadesAutonomasEspania();
        $this->loadProvinciasEspania();
        
        $this->loadDistritoFederalArgentina();
        $this->loadProvinciasArgentina();
        $this->loadPartidosArgentina();
        $this->loadCiudadesArgentina();
        $this->loadBarriosArgentina();
        
        $this->loadConfiguracionCordobaArgentina();        

        $this->loadMetadata(); // Borrame
        $manager->flush();
    }

    public function loadMetadata()
    {        
        $manager = $this->getManager();

        $entity = new EntityTableMetadata( '\Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa' );
        $entity->addAttribute(new AttributeMetadata("himno", "string"));
        $entity->addAttribute(new AttributeMetadata("gentilicio", "string"));
        $entity->addAttribute(new AttributeMetadata("moneda", "object", array('entityType'=>'\Pronit\ParametrizacionGeneralBundle\Entity\Moneda') ));
                
        $manager->persist($entity);       
        $manager->flush();        
    }
    
    public function loadPaises()
    {        
        $manager = $this->getManager();
        
        $tipoDivisionAdministrativaPais = $this->getReference('pronit-geographic-tipodivisionadministrativa-pais');
        
        $paises = array( 'argentina' => 'Argentina', 'espania' =>  'España' );
        
        foreach( $paises as $clave => $valor )
        {
            $pais = new DivisionAdministrativa();
            $pais->setNombre($valor);
            $pais->setTipo($tipoDivisionAdministrativaPais);
            
            $manager->persist($pais);       
            
            $this->addReference('pronit-geographic-pais-' . $clave, $pais);
        }                    
    }

    public function loadProvinciasArgentina()
    {  
        $manager = $this->getManager();
        
        $tipoDivisionAdministrativaProvincia = $this->getReference('pronit-geographic-tipodivisionadministrativa-provincia');
        
        $argentina = $this->getReference('pronit-geographic-pais-argentina');        
        
        $provincias = array( 'buenos aires' => 'Buenos Aires', 'cordoba' => 'Córdoba', 'san luis' => 'San Luis', 'santa fe' => 'Santa Fé');        
        
        foreach( $provincias as $claveProvincia => $nombreProvincia )
        {
            $provincia = new DivisionAdministrativa();
            $provincia->setNombre($nombreProvincia);
            $provincia->setTipo($tipoDivisionAdministrativaProvincia);            
            $provincia->setParent($argentina);
            
            $manager->persist($provincia);       
            
            $this->addReference('pronit-geographic-provincia-' . $claveProvincia, $provincia);
        }                    
    }

    public function loadPartidosArgentina()
    {        
        $manager = $this->getManager();
        
        $tipoDivisionAdministrativaPartido = $this->getReference('pronit-geographic-tipodivisionadministrativa-partido');
        
        $buenosaires = $this->getReference('pronit-geographic-provincia-buenos aires');        
        
        $data= array( 
            array( "nombre" => "Avellaneda", ),
            array( "nombre" => "Bahía Blanca", ),
            array( "nombre" => "La Plata", ),
            array( "nombre" => "Mar del Plata",),            
        );
        
        foreach( $data as $d )
        {
            $partido = new DivisionAdministrativa();
            $partido->setNombre($d['nombre']);
            $partido->setTipo($tipoDivisionAdministrativaPartido);
            $partido->setParent($buenosaires);
            
            $manager->persist($partido);       
            
            $this->addReference('pronit-geographic-partido-' . mb_strtolower( $partido->getNombre() ), $partido);
        }                    
    }
    
    public function loadConfiguracionCordobaArgentina()
    {        
        $manager = $this->getManager();
        
        $provincia = $this->getReference('pronit-geographic-provincia-cordoba');
        
        $tipoDivisionAdministrativaDepartamento = $this->getReference('pronit-geographic-tipodivisionadministrativa-departamento');                
        
        /** Departamentos **/
        $data= array( 
            array( "nombre" => "Capital", ),
            array( "nombre" => "Punilla", ),
        );
        
        foreach( $data as $d )
        {
            $departamento = new DivisionAdministrativa();
            $departamento->setNombre($d['nombre']);
            $departamento->setTipo($tipoDivisionAdministrativaDepartamento);
            $departamento->setParent($provincia);
            
            $manager->persist($departamento);       
            
            $this->addReference('pronit-geographic-departamento-' . mb_strtolower( $departamento->getNombre() ), $departamento);
        }                    
        
        /** Pedanías **/
        
        $tipoDivisionAdministrativaPedania = $this->getReference('pronit-geographic-tipodivisionadministrativa-pedania');
        
        $data = array(
            array( 'nombre' => 'San Roque', 'departamento' => 'punilla' ),
        );
        
        foreach( $data as $d )
        {
            $pedania = new DivisionAdministrativa();
            $pedania->setNombre($d['nombre']);
            $pedania->setTipo($tipoDivisionAdministrativaPedania);
            $pedania->setParent($this->getReference('pronit-geographic-departamento-'.$d['departamento']));
            
            $manager->persist($pedania);       
            
            $this->addReference('pronit-geographic-pedania-' . mb_strtolower( $pedania->getNombre() ), $pedania);
        }                
        
        /** Ciudades **/

        $tipoDivisionAdministrativaCiudad = $this->getReference('pronit-geographic-tipodivisionadministrativa-ciudad');
        
        $data = array(
            array( 'nombre' => 'Villa Carlos Paz', 'pedania' => 'san roque' ),
        );
        
        foreach( $data as $d )
        {
            $ciudad = new DivisionAdministrativa();
            $ciudad->setNombre($d['nombre']);
            $ciudad->setTipo($tipoDivisionAdministrativaCiudad);
            $ciudad->setParent($this->getReference('pronit-geographic-pedania-'.$d['pedania']));
            
            $manager->persist($ciudad);       
            
            $this->addReference('pronit-geographic-ciudad-' . mb_strtolower( $ciudad->getNombre() ), $ciudad);
        }                
        
    }    

    public function loadCiudadesArgentina()
    {        
        $manager = $this->getManager();
               
        $tipoDivisionAdministrativa = $this->getReference('pronit-geographic-tipodivisionadministrativa-ciudad');
        
        $avellaneda = $this->getReference('pronit-geographic-partido-avellaneda');
        
        /**Ciudad de Avellaneda*/
        $dataAvellaneda= array( 
            array( "nombre" => "Avellaneda", "partido" => $avellaneda),
            array( "nombre" => "Dock Sud", "partido" => $avellaneda ),
            array( "nombre" => "Villa Domínico", "partido" => $avellaneda ),
            array( "nombre" => "Wilde", "partido" => $avellaneda),            
        );

        $laplata = $this->getReference('pronit-geographic-partido-la plata');
        
        /**Ciudad de La Plata*/
        $dataLaPlata= array( 
            array( "nombre" => "La Plata", "partido" => $laplata),
            array( "nombre" => "Joaquín Gorina", "partido" => $laplata),
            array( "nombre" => "Manuel B. Gonnet", "partido" => $laplata),
            array( "nombre" => "City Bell", "partido" => $laplata),     
        );
        
        $data = array_merge($dataLaPlata, $dataAvellaneda);
        
        foreach( $data as $d )
        {
            $ciudad = new DivisionAdministrativa();
            $ciudad->setNombre($d['nombre']);
            $ciudad->setTipo($tipoDivisionAdministrativa);
            $ciudad->setParent($d['partido']);
            
            $manager->persist($ciudad);       
            
            $this->addReference('pronit-geographic-ciudad-' . mb_strtolower( $ciudad->getNombre() ), $ciudad);
        }                    
    }

    public function loadDistritoFederalArgentina()
    {        
        $manager = $this->getManager();
        
        $tipoDivisionAdministrativa = $this->getReference('pronit-geographic-tipodivisionadministrativa-distritofederal');
        
        $argentina = $this->getReference('pronit-geographic-pais-argentina');
        
        $distritoFederal = new DivisionAdministrativa();
        $distritoFederal->setNombre('Capital Federal');
        $distritoFederal->setTipo($tipoDivisionAdministrativa);
        $distritoFederal->setParent($argentina);

        $manager->persist($distritoFederal);       

        $this->addReference('pronit-geographic-distrito federal-' . mb_strtolower( $distritoFederal->getNombre() ), $distritoFederal);
    }

    public function loadBarriosArgentina()
    {        
        $manager = $this->getManager();
        
        $tipoDivisionAdministrativa = $this->getReference('pronit-geographic-tipodivisionadministrativa-barrio');
        
        $distritoFederal = $this->getReference('pronit-geographic-distrito federal-capital federal');
        
        /**Barrios de la Capital*/
        $dataCapital= array( 
            array( "nombre" => "Belgrano", "parent" => $distritoFederal),
            array( "nombre" => "Caballito", "parent" => $distritoFederal),
            array( "nombre" => "Recoleta", "parent" => $distritoFederal),
        );

        $data = array_merge($dataCapital);
        
        foreach( $data as $d )
        {
            $barrio = new DivisionAdministrativa();
            $barrio->setNombre($d['nombre']);
            $barrio->setTipo($tipoDivisionAdministrativa);
            $barrio->setParent($d['parent']);
            
            $manager->persist($barrio);       
            
            $this->addReference('pronit-geographic-barrio-' . mb_strtolower( $barrio->getNombre() ), $barrio);
        }                    
    }
    
    public function loadComunidadesAutonomasEspania()
    {
        $manager = $this->getManager();
        
        $espania = $this->getReference('pronit-geographic-pais-espania');
        $tipoDivisionAdministrativaComunidadAutonoma = $this->getReference('pronit-geographic-tipodivisionadministrativa-comunidadautonoma');
        
        $comunidadesAutonomas = array( 'andalucia' => 'Andalucía', 'islascanarias' => 'Islas Canarias', 'castillayleon' => 'Castilla y León', 'comunidaddemadrid' => 'Comunidad de Madrid', 'paisvasco' => 'Pais Vasco' );        
        
        foreach( $comunidadesAutonomas as $clave => $valor )
        {
            $comunidadAutonoma = new DivisionAdministrativa();
            $comunidadAutonoma->setNombre($valor);
            $comunidadAutonoma->setTipo($tipoDivisionAdministrativaComunidadAutonoma);
            $comunidadAutonoma->setParent($espania);
            
            $manager->persist($comunidadAutonoma);       
            
            $this->addReference('pronit-geographic-comunidadautonoma-' . $clave, $comunidadAutonoma);
        }                    
    }
    
    public function loadProvinciasEspania()
    {  
        $manager = $this->getManager();
        
        $tipoDivisionAdministrativaProvincia = $this->getReference('pronit-geographic-tipodivisionadministrativa-provincia');
        
        $comunidadDeMadrid = $this->getReference('pronit-geographic-comunidadautonoma-comunidaddemadrid');

        $provinciasComunidadDeMadrid = array( 
            array( 'nombre' => 'Madrid', 'comunidadAutonoma' => $comunidadDeMadrid),
        );

        $comunidadPaisVasco = $this->getReference('pronit-geographic-comunidadautonoma-paisvasco');
        
        $provinciasPaisVasco = array( 
            array( 'nombre' => 'Alavá', 'comunidadAutonoma' => $comunidadPaisVasco),
            array( 'nombre' => 'Guipúzcoa', 'comunidadAutonoma' => $comunidadPaisVasco),
            array( 'nombre' => 'Vizcaya', 'comunidadAutonoma' => $comunidadPaisVasco),
        );

        $comunidadCastillaYLeon = $this->getReference('pronit-geographic-comunidadautonoma-castillayleon');
        
        $provinciasComunidadCastillaYLeon = array( 
            array( 'nombre' => 'Ávila', 'comunidadAutonoma' => $comunidadCastillaYLeon),
            array( 'nombre' => 'Burgos', 'comunidadAutonoma' => $comunidadCastillaYLeon),
            array( 'nombre' => 'León', 'comunidadAutonoma' => $comunidadCastillaYLeon),
            array( 'nombre' => 'Palencia', 'comunidadAutonoma' => $comunidadCastillaYLeon),
            array( 'nombre' => 'Salamanca', 'comunidadAutonoma' => $comunidadCastillaYLeon),
            array( 'nombre' => 'Segovia', 'comunidadAutonoma' => $comunidadCastillaYLeon),
            array( 'nombre' => 'Soria', 'comunidadAutonoma' => $comunidadCastillaYLeon),
            array( 'nombre' => 'Valladolid', 'comunidadAutonoma' => $comunidadCastillaYLeon),
            array( 'nombre' => 'Zamora', 'comunidadAutonoma' => $comunidadCastillaYLeon),            
        );
        
        $provincias = array_merge($provinciasComunidadDeMadrid , $provinciasPaisVasco, $provinciasComunidadCastillaYLeon);
        
        foreach( $provincias as $provinciaInfo ){
            
            $provincia = new DivisionAdministrativa();
            $provincia->setNombre($provinciaInfo['nombre']);
            $provincia->setTipo($tipoDivisionAdministrativaProvincia);
            $provincia->setParent($provinciaInfo['comunidadAutonoma']);
            
            $manager->persist($provincia);       
        }            
        
    }
    
    function getOrder()
    {
        return 11; 
    }
}
