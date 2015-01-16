<?php
namespace Pronit\CoreBundle\Model\Contabilidad\Movimientos;

use Pronit\CoreBundle\Model\Contabilidad\Esquemas\EsquemaContable;

/**
 *
 * @author gcaseres
 */
interface IGeneradorAsientosContables {
    /**
     * 
     * @param \Pronit\CoreBundle\Model\Contabilidad\Esquemas\EsquemaContable
     * @return \ArrayObject
     */    
    public function generarDesdeEsquema(EsquemaContable $esquema);
}
