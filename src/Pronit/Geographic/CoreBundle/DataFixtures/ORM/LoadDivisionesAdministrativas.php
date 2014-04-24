<?php

namespace Pronit\Geographic\CoreBundle\DataFixtures\ORM;

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

        $this->loadMonedas(); // Borrame
        
        $this->loadMetadata(); // Borrame
        $manager->flush();
        

        // Para cargar atributos necesito tener los ids generados de las monedas, metadata y pais
        //$this->loadMetadataArgentina(); // Borrame
        
        $manager->flush();
    }

    public function loadMetadata()
    {        
        $manager = $this->getManager();

        $entity = new EntityTableMetadata( '\Pronit\Geographic\CoreBundle\Entity\DivisionAdministrativa' );
        $entity->addAttribute(new AttributeMetadata("himno", "string"));
        $entity->addAttribute(new AttributeMetadata("moneda", "object", array('entityType'=>'\Pronit\ParametrizacionGeneralBundle\Entity\Moneda') ));
                
        $manager->persist($entity);       
        $manager->flush();        
    }
    
    public function loadMonedas()
    {        
        $manager = $this->getManager();
        
        $moneda = new Moneda( "Peso" , "Peso", "$", "ARS" );
            
        $manager->persist($moneda);       
            
        $this->addReference('moneda', $moneda);                    
    }
    
    public function loadPaises()
    {        
        $manager = $this->getManager();
        
        $tipoDivisionAdministrativaPais = $this->getReference('pronit-geographic-tipodivisionadministrativa-pais');
        
        $paises = array( 'Argentina', 'España' );
        
        foreach( $paises as $nombrePais )
        {
            $pais = new DivisionAdministrativa($nombrePais, $tipoDivisionAdministrativaPais);
            $manager->persist($pais);       
            
            $this->addReference('pronit-geographic-pais-' . strtolower( $nombrePais ), $pais);
        }                    
    }

    public function loadProvinciasArgentina()
    {  
        $manager = $this->getManager();
        
        $tipoDivisionAdministrativaProvincia = $this->getReference('pronit-geographic-tipodivisionadministrativa-provincia');
        
        $argentina = $this->getReference('pronit-geographic-pais-argentina');        
        
        $provincias = array( 'Buenos Aires', 'San Luis');        
        
        foreach( $provincias as $nombreProvincia )
        {
            $provincia = new DivisionAdministrativa($nombreProvincia, $tipoDivisionAdministrativaProvincia);
            $provincia->setParent($argentina);
            
            $manager->persist($provincia);       
            
            $this->addReference('pronit-geographic-provincia-' . strtolower( $provincia->getNombre() ), $provincia);
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
            $partido = new DivisionAdministrativa($d['nombre'], $tipoDivisionAdministrativaPartido);
            $partido->setParent($buenosaires);
            
            $manager->persist($partido);       
            
            $this->addReference('pronit-geographic-partido-' . strtolower( $partido->getNombre() ), $partido);
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
            $ciudad = new DivisionAdministrativa($d['nombre'], $tipoDivisionAdministrativa);
            $ciudad->setParent($d['partido']);
            
            $manager->persist($ciudad);       
            
            $this->addReference('pronit-geographic-ciudad-' . strtolower( $ciudad->getNombre() ), $ciudad);
        }                    
    }

    public function loadDistritoFederalArgentina()
    {        
        $manager = $this->getManager();
        
        $tipoDivisionAdministrativa = $this->getReference('pronit-geographic-tipodivisionadministrativa-distrito federal');
        
        $argentina = $this->getReference('pronit-geographic-pais-argentina');
        
        $distritoFederal = new DivisionAdministrativa('Capital Federal', $tipoDivisionAdministrativa);
        $distritoFederal->setParent($argentina);

        $manager->persist($distritoFederal);       

        $this->addReference('pronit-geographic-distrito federal-' . strtolower( $distritoFederal->getNombre() ), $distritoFederal);
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
            $barrio = new DivisionAdministrativa($d['nombre'], $tipoDivisionAdministrativa);
            $barrio->setParent($d['parent']);
            
            $manager->persist($barrio);       
            
            $this->addReference('pronit-geographic-barrio-' . strtolower( $barrio->getNombre() ), $barrio);
        }                    
    }
    
    public function loadComunidadesAutonomasEspania()
    {
        $manager = $this->getManager();
        
        $espania = $this->getReference('pronit-geographic-pais-españa');
        $tipoDivisionAdministrativaComunidadAutonoma = $this->getReference('pronit-geographic-tipodivisionadministrativa-comunidad autonoma');
        
        $comunidadesAutonomas = array( 'Andalucía', 'Islas Canarias', 'Castilla y León', 'Comunidad de Madrid', 'Pais Vasco' );        
        
        foreach( $comunidadesAutonomas as $nombreComunidadAutonoma )
        {
            $comunidadAutonoma = new DivisionAdministrativa($nombreComunidadAutonoma, $tipoDivisionAdministrativaComunidadAutonoma);
            $comunidadAutonoma->setParent($espania);
            
            $manager->persist($comunidadAutonoma);       
            
            $this->addReference('pronit-geographic-comunidadautonoma-' . strtolower( $comunidadAutonoma->getNombre() ), $comunidadAutonoma);
        }                    
    }
    
    public function loadProvinciasEspania()
    {  
        $manager = $this->getManager();
        
        $tipoDivisionAdministrativaProvincia = $this->getReference('pronit-geographic-tipodivisionadministrativa-provincia');
        
        $comunidadDeMadrid = $this->getReference('pronit-geographic-comunidadautonoma-comunidad de madrid');

        $provinciasComunidadDeMadrid = array( 
            array( 'nombre' => 'Madrid', 'comunidadAutonoma' => $comunidadDeMadrid),
        );

        $comunidadPaisVasco = $this->getReference('pronit-geographic-comunidadautonoma-pais vasco');
        
        $provinciasPaisVasco = array( 
            array( 'nombre' => 'Alavá', 'comunidadAutonoma' => $comunidadPaisVasco),
            array( 'nombre' => 'Guipúzcoa', 'comunidadAutonoma' => $comunidadPaisVasco),
            array( 'nombre' => 'Vizcaya', 'comunidadAutonoma' => $comunidadPaisVasco),
        );

        $comunidadCastillaYLeon = $this->getReference('pronit-geographic-comunidadautonoma-castilla y león');
        
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
            
            $provincia = new DivisionAdministrativa( $provinciaInfo['nombre'], $tipoDivisionAdministrativaProvincia );
            $provincia->setParent($provinciaInfo['comunidadAutonoma']);
            
            $manager->persist($provincia);       
        }            
        
    }
    
    function getOrder()
    {
        return 2; 
    }
}
