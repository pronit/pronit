<?php
namespace Pronit\ContabilidadBundle\Model\Movimientos;

use ArrayObject;
use Pronit\ContabilidadBundle\Entity\Movimientos\Movimiento;
use Pronit\ContabilidadBundle\Model\Esquemas\EsquemaContable;
use Pronit\ContabilidadBundle\Model\Esquemas\ItemEsquemaContable;

/**
 * Description of GeneradorAsientosContables
 *
 * @author gcaseres
 */
class GeneradorAsientosContables {
    public function generarDesdeEsquema(EsquemaContable $esquema) {
        $result = new ArrayObject();
        
        foreach ($esquema->getItems() as /* @var $item ItemEsquemaContable */ $item) {
            $movimiento = new Movimiento(1, new \DateTime(), "", $item->getCuenta(), $item->getMonto() * $item->getOperacion()->getClaveContabilizacion()->getSigno());
            $result->append($movimiento);            
        }
        
        return $result;
    }
}
