<?php
namespace Pronit\CoreBundle\Model\Contabilidad\Movimientos;

use ArrayObject;
use DateTime;
use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\Movimiento;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\EsquemaContable;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\ItemEsquemaContable;

/**
 * Description of GeneradorAsientosContables
 *
 * @author gcaseres
 */
class GeneradorAsientosContables implements IGeneradorAsientosContables {
    public function generarDesdeEsquema(EsquemaContable $esquema) {
        $result = new ArrayObject();
        
        foreach ($esquema->getItems() as /* @var $item ItemEsquemaContable */ $item) {
            $movimiento = new Movimiento(1, new DateTime(), "", $item->getCuenta(), $item->getMonto() * $item->getOperacion()->getClaveContabilizacion()->getSigno());
            $result->append($movimiento);            
        }
        
        return $result;
    }
}
