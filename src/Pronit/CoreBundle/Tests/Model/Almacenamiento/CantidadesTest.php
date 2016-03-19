<?php

namespace Pronit\CoreBundle\Tests\Model\Almacenamiento;

use Pronit\CoreBundle\Model\Almacenamiento\Cantidades;
use Pronit\ParametrizacionGeneralBundle\Entity\Escala;
use Pronit\ParametrizacionGeneralBundle\Entity\SistemaMedicion;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 *
 * @author gcaseres
 */
class CantidadesTest extends KernelTestCase {

    private function createSistemas() {
        $result = array();

        $sistema_metros = new SistemaMedicion('Metros', 'Mts');
        $sistema_metros->addEscala(new Escala('Metros', 'm', 1));
        $sistema_metros->addEscala(new Escala('Centímetros', 'cm', 0.01));
        $result['metros'] = $sistema_metros;

        $sistema_litros = new SistemaMedicion('Litros', 'Lts');
        $sistema_litros->addEscala(new Escala('Litros', 'l', 1));
        $sistema_litros->addEscala(new Escala('Mililitros', 'ml', 0.001));
        $result['litros'] = $sistema_litros;


        return $result;
    }

    public function testSet() {
        $sistemas = $this->createSistemas();

        $escalas_litros = $sistemas['litros']->getEscalas();
        $escalas_metros = $sistemas['metros']->getEscalas();

        $cantidades = new Cantidades();

        $cantidades->set(10, $escalas_litros[0]);

        $this->assertEquals(1, $cantidades->count());

        $this->assertEquals(10, $cantidades->get($sistemas['litros'])->getValor());

        $cantidades->set(10000, $escalas_litros[1]);

        $this->assertEquals(1, $cantidades->count(), 'Se esperaba que la asignación de una nueva cantidad del mismo sistema de medición no agregue una cantidad nueva sino que sobreescriba la anterior.');

        $this->assertEquals(10000, $cantidades->get($sistemas['litros'])->getValor(), 'Se esperaba que la asignación de una nueva cantidad del mismo sistema de medición no agregue una cantidad nueva sino que sobreescriba la anterior.');
        
        $cantidades->set(10, $escalas_metros[0]);
        
        $this->assertEquals(2, $cantidades->count(), 'Se esperaba que la asignación de una nueva cantidad de un sistema de medición diferente agregue una cantidad nueva.');
    }
    
    public function testGet() {
        $sistemas = $this->createSistemas();

        $escalas_litros = $sistemas['litros']->getEscalas();

        $cantidades = new Cantidades();
        
        $cantidades->set(10, $escalas_litros[0]);

        $this->assertEquals(1, $cantidades->count());

        $this->assertEquals(10, $cantidades->get($sistemas['litros'])->getValor());        
    }

}
