<?php

namespace Pronit\GestionBienesYServiciosBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Pronit\GestionBienesYServiciosBundle\Entity\Material;
use Pronit\GestionBienesYServiciosBundle\Entity\Servicio;

use Pronit\GestionBienesYServiciosBundle\Entity\Customizing\EstructuraEmpresa\BienServicioSociedadFI;

/**
 * @author ldelia
 */
class LoadBienesYServicios extends AbstractFixture implements FixtureInterface , OrderedFixtureInterface, ContainerAwareInterface
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

        $this->loadMateriales();
        $this->loadServicios();
        
        $manager->flush();        
        
    }   
    
    protected function loadMateriales()
    {
        $sistemaMedicionLitro = $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-litro');

        $values = array(
            array('codigo' => "MM001", 
                    "nombre" => "Aditivo A1SW", 
                    'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3006'), 
                    'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-productoelaborado'),
                    "sistemaMedicion" => $sistemaMedicionLitro),
            array('codigo' => "610615008", 
                    "nombre" => "Caja Telescopica I 3 90 Libras", 
                    'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3001'), 
                    'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-productoelaborado'),
                    "sistemaMedicion" => $sistemaMedicionLitro),
        );
        
        foreach( $values as $v ){
            
            $bienServicio = new Material();
            $bienServicio->setCodigo( $v['codigo'] );
            $bienServicio->setNombre( $v['nombre'] );
            $bienServicio->setCategoriaValoracion( $v['categoria'] );
            $bienServicio->setTipo( $v['tipo'] );
            $bienServicio->setSistemaMedicion( $v['sistemaMedicion'] );
        
            $this->manager->persist($bienServicio);
            
            $this->addReference('pronit-gestionbienesyservicios-bienservicio-' . $v['codigo'], $bienServicio);        
            
            /**
             * Por defecto, todos los bienes y servicios corresponden a la única sociedad fi
             */
            $bienServicioSociedadFI = new BienServicioSociedadFI();
            $bienServicioSociedadFI->setBienServicio($bienServicio);
            $bienServicioSociedadFI->setCodigo($bienServicio->getCodigo());
            $bienServicioSociedadFI->setPrecioValoracionEstandar( null ); /** @todo */
            $bienServicioSociedadFI->setPrecioValoracionPromedio( null ); /** @todo */
            $bienServicioSociedadFI->setSociedadFI( $this->getReference('pronit-estructuraempresa-sociedadfi') );
            
            $this->manager->persist($bienServicioSociedadFI);
        }        
    }

    protected function loadServicios()
    {
        $sistemaMedicionLitro = $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-tiempo');

        $values = array(
            array('codigo' => "SS001", 
                    "nombre" => "Clean Fast", 
                    'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3006'), 
                    'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-limpieza'),
                    "sistemaMedicion" => $sistemaMedicionLitro),
            array('codigo' => "SS002", 
                    "nombre" => "KZN", 
                    'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3001'), 
                    'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-consultoria'),
                    "sistemaMedicion" => $sistemaMedicionLitro),
        );
        
        foreach( $values as $v ){
            
            $bienServicio = new Servicio();
            $bienServicio->setCodigo( $v['codigo'] );
            $bienServicio->setNombre( $v['nombre'] );
            $bienServicio->setCategoriaValoracion( $v['categoria'] );
            $bienServicio->setTipo( $v['tipo'] );
            $bienServicio->setSistemaMedicion( $v['sistemaMedicion'] );
        
            $this->manager->persist($bienServicio);
            
            $this->addReference('pronit-gestionbienesyservicios-bienservicio-' . $v['codigo'], $bienServicio);        
            
            /**
             * Por defecto, todos los bienes y servicios corresponden a la única sociedad fi
             */
            $bienServicioSociedadFI = new BienServicioSociedadFI();
            $bienServicioSociedadFI->setBienServicio($bienServicio);
            $bienServicioSociedadFI->setCodigo($bienServicio->getCodigo());
            $bienServicioSociedadFI->setPrecioValoracionEstandar( null ); /** @todo */
            $bienServicioSociedadFI->setPrecioValoracionPromedio( null ); /** @todo */
            $bienServicioSociedadFI->setSociedadFI( $this->getReference('pronit-estructuraempresa-sociedadfi') );
            
            $this->manager->persist($bienServicioSociedadFI);            
        }        
    }
    
    function getOrder()
    {
        return 72; 
    }
}
