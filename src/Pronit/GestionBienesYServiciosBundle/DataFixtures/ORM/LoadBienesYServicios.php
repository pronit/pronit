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
        $values = array();

        $values[] = array('codigo' => "R5-471T",
            "nombre" => "Aspire R5-471T",
            'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3006'),
            'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-productoelaborado'),
            "sistemaMedicion" => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades'),
            'presentacionesCompra' => array(),
            'presentacionesVenta' => array(),
        );
        $values[] = array('codigo' => "RAM-4GB",
            "nombre" => "RAM 4GB",
            'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3006'),
            'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-productoelaborado'),
            "sistemaMedicion" => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades'),
            'presentacionesCompra' => array(),
            'presentacionesVenta' => array(),
        );
        $values[] = array('codigo' => "INTEL-Graphics-520",
            "nombre" => "Intel HD Graphics 520",
            'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3006'),
            'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-productoelaborado'),
            "sistemaMedicion" => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades'),
            'presentacionesCompra' => array(),
            'presentacionesVenta' => array(),
        );
        $values[] = array('codigo' => "INTEL-i5-6200U",
            "nombre" => "Intel Core i5-6200U processor 2.30 GHz",
            'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3006'),
            'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-productoelaborado'),
            "sistemaMedicion" => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades'),
            'presentacionesCompra' => array(),
            'presentacionesVenta' => array(),
        );
        
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

        $values[] = array('codigo' => "6796342",
            "nombre" => "Pintura blanco brillante ST",
            'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3001'),
            'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-productoelaborado'),
            "sistemaMedicion" => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades'),
            "sociedadFI_precioValoracionEstandar" => 4,
            'presentacionesCompra' => array( 
                array( 
                    "nombre" => "Balde de 60 lts"
                ),
            ),
            'presentacionesVenta' => array( 
                array( 
                    "nombre" => "Balde de 60 lts",
                    "unidades" => array(
                        $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                    ),
                ),
            )            
        );
        
        $values[] = array('codigo' => "514612011",
            "nombre" => "Ibupirac 600 Capsulas Blandas",
            'categoria' => $this->getReference('pronit-gestionbienesyservicios-categoriavaloracion-3001'),
            'tipo' => $this->getReference('pronit-gestionbienesyservicios-tipobienservicio-productoelaborado'),
            "sistemaMedicion" => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades'),
            "sociedadFI_precioValoracionEstandar" => 4,
            'presentacionesCompra' => array( 
                array( 
                    "nombre" => "Palet X 50 Ibupirac 600 Capsulas Blandas x 10", 
                    'fraccionamiento' => array( 
                        'cantidad' => 50, 
                        'unidad' => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                        'presentacionVenta' => 'Ibupirac 600 Capsulas Blandas x 10'
                    ) 
                ),
            ),
            'presentacionesVenta' => array( 
                array( 
                    "nombre" => "Ibupirac 600 Capsulas Blandas x 10",
                    "unidades" => array(
                        $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                    ),
                    'fraccionamiento' => array( 
                        'cantidad' => 10, 
                        'unidad' => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                        'presentacionVenta' => 'Suelto'
                    ) 
                ),
                array( 
                    "nombre" => "Suelto",
                    "unidades" => array(
                        $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                    )
                ),                
            )
            
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
                    'fraccionamiento' => array( 
                        'cantidad' => 5, 
                        'unidad' => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                        'presentacionVenta' => 'Bolsa 25kg'
                    ) 
                ),
            ),
            'presentacionesVenta' => array( 
                array( 
                    "nombre" => "Bolsa 25kg",
                    "unidades" => array(
                        $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                    ),
                    'fraccionamiento' => array( 
                        'cantidad' => 25, 
                        'unidad' => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-kilos-escala-kilo'),
                        'presentacionVenta' => 'Suelto'
                    )                     
                ),
                array( 
                    "nombre" => "Suelto",
                    "unidades" => array(
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
                    'fraccionamiento' => array( 
                        'cantidad' => 6, 
                        'unidad' => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                        'presentacionVenta' => 'Botella 750ml'
                    ) 
                ),
                array( 
                    "nombre" => "Caja x 12", 
                    'fraccionamiento' => array( 
                        'cantidad' => 12, 
                        'unidad' => $this->getReference('pronit-parametrizaciongeneral-sistemamedicion-unidades-escala-unidad'),
                        'presentacionVenta' => 'Botella 750ml'
                    ) 
                ),                
            ),
            'presentacionesVenta' => array( 
                array( 
                    "nombre" => "Botella 750ml",
                    "unidades" => array(
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

            /**
             * Se generan las presentaciones de venta y de compra
             */
            foreach( $v['presentacionesCompra'] as $pc ){
                
                $presentacionCompra = new \Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionCompra();
                $presentacionCompra->setNombre($pc['nombre']);

                $bienServicio->addPresentacionCompra($presentacionCompra);                
                
                $this->addReference('pronit-gestionbienesyservicios-bienservicio-' . $v['codigo'] . '-presentacionCompra-' . $pc['nombre'], $presentacionCompra);
            }
            
            foreach( $v['presentacionesVenta'] as $pv ){
                
                $presentacionVenta = new \Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta();
                $presentacionVenta->setNombre($pv['nombre']);                
                foreach ( $pv['unidades'] as $unidad){                    
                    $presentacionVenta->addUnidad($unidad);
                }                                                

                $bienServicio->addPresentacionVenta($presentacionVenta);                
                
                $this->addReference('pronit-gestionbienesyservicios-bienservicio-' . $v['codigo'] . '-presentacionVenta-' . $pv['nombre'], $presentacionVenta);
            }
            
            /**
             * Se continúa con la carga de fraccionamiento. Esto no se puede hacer en la pasada anterior porque no estaban todas las referencias cargadas
             */

            foreach( $v['presentacionesCompra'] as $pc ){
                
                if( isset( $pc['fraccionamiento'] ) ){
                    
                    $presentacionCompra = $this->getReference('pronit-gestionbienesyservicios-bienservicio-' . $v['codigo'] . '-presentacionCompra-' . $pc['nombre']);
                                    
                    $fraccionamiento = new \Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\FraccionamientoCompra();
                    $fraccionamiento->setCantidad($pc['fraccionamiento']['cantidad']);
                    $fraccionamiento->setUnidad($pc['fraccionamiento']['unidad']);
                    $fraccionamiento->setPresentacionDestino( $this->getReference( 'pronit-gestionbienesyservicios-bienservicio-' . $v['codigo'] . '-presentacionVenta-' . $pc['fraccionamiento']['presentacionVenta'] ) );                    
                    
                    $presentacionCompra->setFraccionamiento($fraccionamiento);
                }
            }

            foreach( $v['presentacionesVenta'] as $pv ){                

                if( isset( $pv['fraccionamiento'] ) ){
                    
                    $presentacionVenta = $this->getReference('pronit-gestionbienesyservicios-bienservicio-' . $v['codigo'] . '-presentacionVenta-' . $pv['nombre']);

                    $fraccionamiento = new \Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\FraccionamientoVenta();
                    $fraccionamiento->setCantidad($pv['fraccionamiento']['cantidad']);
                    $fraccionamiento->setUnidad($pv['fraccionamiento']['unidad']);
                    $fraccionamiento->setPresentacionDestino( $this->getReference( 'pronit-gestionbienesyservicios-bienservicio-' . $v['codigo'] . '-presentacionVenta-' . $pv['fraccionamiento']['presentacionVenta'] ) );

                    $presentacionVenta->setFraccionamientoVentaDestino($fraccionamiento);                    
                }
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
            $bienServicioSociedadFI->setSociedadFI($this->getReference('pronit-estructuraempresa-sociedadfi-modelosa'));

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
            $bienServicioSociedadFI->setSociedadFI($this->getReference('pronit-estructuraempresa-sociedadfi-modelosa'));

            $this->manager->persist($bienServicioSociedadFI);
        }
    }

    function getOrder() {
        return 72;
    }

}
