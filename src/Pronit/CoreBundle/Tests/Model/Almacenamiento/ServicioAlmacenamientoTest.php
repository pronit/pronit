<?php

namespace Pronit\CoreBundle\Tests\Model\Almacenamiento;

use Exception;
use Pronit\CoreBundle\Entity\Almacenamiento\Existencia;
use Pronit\CoreBundle\Entity\Almacenamiento\Repository\IExistenciaRepository;
use Pronit\CoreBundle\Entity\BienesYServicios\Presentaciones\PresentacionVenta;
use Pronit\CoreBundle\Model\Almacenamiento\Cantidades;
use Pronit\CoreBundle\Model\Almacenamiento\ServicioAlmacenamiento;
use Pronit\EstructuraEmpresaBundle\Entity\Almacen;
use Pronit\GestionBienesYServiciosBundle\Entity\Material;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;
use Pronit\ParametrizacionGeneralBundle\Entity\SistemaMedicion;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 *
 * @author gcaseres
 */
class ServicioAlmacenamientoTest extends KernelTestCase {

    private function createSistemasMedicion() {
        $result = array();

        $sistema_kilos = new SistemaMedicion('Kilos', 'Kgs.');
        $sistema_kilos->addEscala(new Escala('Kilos', 'kg', 1000));
        $sistema_kilos->addEscala(new Escala('Gramos', 'g', 1));
        $result['kilos'] = $sistema_kilos;

        $sistema_unidades = new SistemaMedicion('Unidades', 'Unidades');
        $sistema_unidades->addEscala(new Escala('Unidad', 'UN', 1));
        $result['unidades'] = $sistema_unidades;


        return $result;
    }

    /**
     * 
     * @expectedException Exception
     */
    public function testModificarExistenciasConUnidadesIncorrectas() {
        $sistemasMedicion = $this->createSistemasMedicion();
        $escalas_unidades = $sistemasMedicion['unidades']->getEscalas();
        $escalas_kilos = $sistemasMedicion['kilos']->getEscalas();

        $servicioAlmacenamiento = new ServicioAlmacenamiento($this->getMock('Pronit\CoreBundle\Entity\Almacenamiento\Repository\IExistenciaRepository'));

        $presentacion = new PresentacionVenta('Caja');
        $presentacion->addUnidad($escalas_unidades[0]);
        $presentacion->addUnidad($escalas_kilos[0]);

        $cantidades = new Cantidades();

        $cantidades->set(10, $escalas_unidades[0]);

        $servicioAlmacenamiento->modificarExistencias($presentacion, $cantidades);
    }

    public function testModificarExistencias() {
        $sistemasMedicion = $this->createSistemasMedicion();
        $escalas_unidades = $sistemasMedicion['unidades']->getEscalas();
        $escalas_kilos = $sistemasMedicion['kilos']->getEscalas();
        
        $almacen = new Almacen();
        $presentacion = new PresentacionVenta('Caja');
        $presentacion->addUnidad($escalas_unidades[0]);
        $presentacion->addUnidad($escalas_kilos[0]);

        $material = new Material();
        $material->addPresentacionVenta($presentacion);
        
        $existencia = new Existencia($almacen, $material);
        $existencia->addPresentacion($presentacion, array($escalas_unidades[0], $escalas_kilos[0]));
        
        
        /* @var $existenciaRepository IExistenciaRepository */
        $existenciaRepository = $this->getMock('Pronit\CoreBundle\Entity\Almacenamiento\Repository\IExistenciaRepository');
        $existenciaRepository->method('findByMaterial')->will($this->returnValue($existencia));

        $servicioAlmacenamiento = new ServicioAlmacenamiento($existenciaRepository);        

        $cantidades = new Cantidades();

        $cantidades->set(1, $escalas_unidades[0]);
        $cantidades->set(1500, $escalas_kilos[1]);

        $servicioAlmacenamiento->modificarExistencias($presentacion, $cantidades);
        
        $this->assertEquals(1, $existencia->getCantidad($presentacion, $escalas_unidades[0]));
        $this->assertEquals(1.5, $existencia->getCantidad($presentacion, $escalas_kilos[0]));
        

        $cantidades->set(1, $escalas_unidades[0]);
        $cantidades->set(-1, $escalas_kilos[0]);

        $servicioAlmacenamiento->modificarExistencias($presentacion, $cantidades);
        
        $this->assertEquals(2, $existencia->getCantidad($presentacion, $escalas_unidades[0]));
        $this->assertEquals(0.5, $existencia->getCantidad($presentacion, $escalas_kilos[0]));        
    }

    public function testConfigurar() {
        $sistemasMedicion = $this->createSistemasMedicion();
        $escalas_unidades = $sistemasMedicion['unidades']->getEscalas();
        $escalas_kilos = $sistemasMedicion['kilos']->getEscalas();

        $almacen = new Almacen();
        $presentacion = new PresentacionVenta('Caja');
        $presentacion->addUnidad($escalas_unidades[0]);
        $presentacion->addUnidad($escalas_kilos[0]);

        $material = new Material();
        $material->addPresentacionVenta($presentacion);
        

        /* @var $existenciaConfigurada Existencia */
        $existenciaConfigurada = null;

        /* @var $existenciaRepository IExistenciaRepository */
        $existenciaRepository = $this->getMock('Pronit\CoreBundle\Entity\Almacenamiento\Repository\IExistenciaRepository');
        $existenciaRepository->method('findByMaterial');
        $existenciaRepository->method('add')->will($this->returnCallback(function($existencia) use (&$existenciaConfigurada) {
                    $existenciaConfigurada = $existencia;
                }));


        $servicioAlmacenamiento = new ServicioAlmacenamiento($existenciaRepository);

        $servicioAlmacenamiento->configurar($material, $almacen);

        $this->assertNotNull($existenciaConfigurada);        
        $this->assertEquals(0, $existenciaConfigurada->getCantidad($presentacion, $escalas_unidades[0]));
        $this->assertEquals(0, $existenciaConfigurada->getCantidad($presentacion, $escalas_kilos[0]));
    }

}
