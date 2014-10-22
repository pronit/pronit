<?php
namespace Pronit\ContabilidadBundle\Model\Movimientos;

use Pronit\ContabilidadBundle\Model\Esquemas\EsquemaContable;

/**
 *
 * @author gcaseres
 */
interface IGeneradorAsientosContables {
    /**
     * 
     * @param \Pronit\ContabilidadBundle\Model\Esquemas\EsquemaContable
     * @return \ArrayObject
     */    
    public function generarDesdeEsquema(EsquemaContable $esquema);
}
