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
class LoadBienesYServicios extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;
    private $manager;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function getManager() {
        return $this->manager;
    }

    public function setManager(ObjectManager $manager) {
        $this->manager = $manager;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $this->setManager($manager);

        $this->loadMateriales();
        $this->loadServicios();

        $manager->flush();
    }

    protected function loadMateriales() {
        $valuesDummies = array();

        $values[] = array('codigo' => "MM001",
            "nombre" => "Aditivo A1SW",
            'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3006'),
            'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-productoelaborado'),
            "sistemaMedicion" => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-litros'),
            'presentacionesCompra' => array(),
            'presentacionesVenta' => array(),
        );
        $values[] = array('codigo' => "610615008",
            "nombre" => "Caja Telescopica I 3 90 Libras",
            'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3001'),
            'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-productoelaborado'),
            "sistemaMedicion" => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-litros'),
            "sociedadFI_precioValoracionEstandar" => 24.0,
            'presentacionesCompra' => array(),
            'presentacionesVenta' => array(),
        );
        
        $values[] = array('codigo' => "610612011",
            "nombre" => "Bolsa Ceral x 25",
            'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3001'),
            'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-productoelaborado'),
            "sistemaMedicion" => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades'),
            "sociedadFI_precioValoracionEstandar" => 4,
            'presentacionesCompra' => array( 
                array( 
                    "nombre" => "Caja x 5", 
                    'fraccionamientos' => array( 
                        array(
                            'cantidad' => 5, 
                            'escala' => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                            'presentacionVenta' => 'Bolsa 25kg'
                        ) 
                    ) 
                ),
            ),
            'presentacionesVenta' => array( 
                array( 
                    "nombre" => "Bolsa 25kg",
                    "escalas" => array(
                        $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                    )
                ),
                array( 
                    "nombre" => "Suelto",
                    "escalas" => array(
                        $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-kilos-escala-kilo'),
                    )
                ),                
            )
            
        );
        
        $values[] = array('codigo' => "610612012",
            "nombre" => "Vino Rutini Malbec x 750 ml",
            'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3001'),
            'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-productoelaborado'),
            "sistemaMedicion" => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades'),
            "sociedadFI_precioValoracionEstandar" => 4,
            'presentacionesCompra' => array( 
                array( 
                    "nombre" => "Caja x 6", 
                    'fraccionamientos' => array( 
                        array(
                            'cantidad' => 6, 
                            'escala' => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                            'presentacionVenta' => 'Botella 750ml'
                        ) 
                    ) 
                ),
                array( 
                    "nombre" => "Caja x 12", 
                    'fraccionamientos' => array( 
                        array( 
                            'cantidad' => 12, 
                            'escala' => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                            'presentacionVenta' => 'Botella 750ml'
                        ) 
                    ) 
                ),                
            ),
            'presentacionesVenta' => array( 
                array( 
                    "nombre" => "Botella 750ml",
                    "escalas" => array(
                        $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                    )
                ),
            )
            
        );

        foreach ($values as $v) {

            $bienServicio = new Material();
            $bienServicio->setCodigo($v['codigo']);
            $bienServicio->setNombre($v['nombre']);
            $bienServicio->setCategoriaValoracion($v['categoria']);
            $bienServicio->setTipo($v['tipo']);
            $bienServicio->setSistemaMedicion($v['sistemaMedicion']);
            
            foreach( $v['presentacionesVenta'] as $pv ){
                
                $presentacionVenta = new \Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta();
                $presentacionVenta->setNombre($pv['nombre']);
                
                foreach ( $pv['escalas'] as $escala){
                    
                    $presentacionVenta->addEscala($escala);
                }                                

                $bienServicio->addPresentacionVenta($presentacionVenta);                
                
                $this->addReference('pronit-gestionbienesyservicios-bienservicio-' . $v['codigo'] . '-presentacionVenta-' . $pv['nombre'], $presentacionVenta);
            }

            foreach( $v['presentacionesCompra'] as $pc ){
                
                $presentacionCompra = new \Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionCompra();
                $presentacionCompra->setNombre($pc['nombre']);

                foreach ( $pc['fraccionamientos'] as $f){
                    
                    $fraccionamiento = new \Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\Fraccionamiento();
                    $fraccionamiento->setCantidad($f['cantidad']);
                    $fraccionamiento->setEscala($f['escala']);
                    $fraccionamiento->setPresentacionVenta( $this->getReference( 'pronit-gestionbienesyservicios-bienservicio-' . $v['codigo'] . '-presentacionVenta-' . $f['presentacionVenta'] ) );
                    
                    $presentacionCompra->addFraccionamiento($fraccionamiento);
                }                

                $bienServicio->addPresentacionCompra($presentacionCompra);                
            }
            
            $this->manager->persist($bienServicio);

            $this->addReference('pronit-gestionbienesyservicios-bienservicio-' . $v['codigo'], $bienServicio);

            /**
             * Por defecto, todos los bienes y servicios corresponden a la única sociedad fi
             */
            $bienServicioSociedadFI = new BienServicioSociedadFI();
            $bienServicioSociedadFI->setBienServicio($bienServicio);
            $bienServicioSociedadFI->setCodigo($bienServicio->getCodigo());
            $bienServicioSociedadFI->setPrecioValoracionEstandar(isset($v["sociedadFI_precioValoracionEstandar"]) ? $v["sociedadFI_precioValoracionEstandar"] : rand(10, 1000) / 10 );
            $bienServicioSociedadFI->setPrecioValoracionPromedio(null);/** @todo */
            $bienServicioSociedadFI->setSociedadFI($this->getReference('pronit-estructuraempresa-sociedadfi'));

            $this->manager->persist($bienServicioSociedadFI);
        }
    }

    protected function loadServicios() {
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

        foreach ($values as $v) {

            $bienServicio = new Servicio();
            $bienServicio->setCodigo($v['codigo']);
            $bienServicio->setNombre($v['nombre']);
            $bienServicio->setCategoriaValoracion($v['categoria']);
            $bienServicio->setTipo($v['tipo']);
            $bienServicio->setSistemaMedicion($v['sistemaMedicion']);

            $this->manager->persist($bienServicio);

            $this->addReference('pronit-gestionbienesyservicios-bienservicio-' . $v['codigo'], $bienServicio);

            /**
             * Por defecto, todos los bienes y servicios corresponden a la única sociedad fi
             */
            $bienServicioSociedadFI = new BienServicioSociedadFI();
            $bienServicioSociedadFI->setBienServicio($bienServicio);
            $bienServicioSociedadFI->setCodigo($bienServicio->getCodigo());
            $bienServicioSociedadFI->setPrecioValoracionEstandar(rand(10, 1000) / 10);
            $bienServicioSociedadFI->setPrecioValoracionPromedio(null);
            $bienServicioSociedadFI->setSociedadFI($this->getReference('pronit-estructuraempresa-sociedadfi'));

            $this->manager->persist($bienServicioSociedadFI);
        }
    }

    function getOrder() {
        return 72;
    }

}
