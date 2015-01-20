<?php

namespace Pronit\CoreBundle\Model\Contabilidad\Movimientos;

use ArrayObject;
use DateTime;
use Pronit\CoreBundle\Entity\Contabilidad\Movimientos\Movimiento;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\EsquemaContable;
use Pronit\CoreBundle\Model\Contabilidad\Esquemas\ItemEsquemaContable;
use Pronit\CoreBundle\Model\Numeraciones\NumeracionSociedadFIManager;

/**
 * Description of GeneradorAsientosContables
 *
 * @author gcaseres
 */
class GeneradorAsientosContables implements IGeneradorAsientosContables {

    private $numeracionSociedadFIManager;

    public function __construct(NumeracionSociedadFIManager $numeracionSociedadFIManager) {
        $this->numeracionSociedadFIManager = $numeracionSociedadFIManager;
    }

    public function generarDesdeEsquema(EsquemaContable $esquema) {
        $result = new ArrayObject();
        $numeroAsiento = $this->numeracionSociedadFIManager->generarNumeroAsiento($esquema->getDocumento()->getSociedad());
        $date = new DateTime();
        
        foreach ($esquema->getItems() as /* @var $item ItemEsquemaContable */ $item) {
            $movimiento = new Movimiento($numeroAsiento, $date, "", $item->getCuenta(), $item->getMonto() * $item->getOperacion()->getClaveContabilizacion()->getSigno());
            $result->append($movimiento);
        }

        return $result;
    }

}
