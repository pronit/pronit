<?php

namespace Pronit\CoreBundle\Model\Automatizacion\Secuencias;

use \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion;
use \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Secuencia;
/**
 *
 * @author ldelia
 */
interface IBuscadorRegistroCondicion
{
    /**
     * 
     * @param type $keyValues
     * @param \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion $tablaCondicion
     * @return \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion | null
     */
    public function buscarPorTablaCondicion( $keyValues, TablaCondicion $tablaCondicion);
    
    /**
     * 
     * @param type $keyValues
     * @param \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Secuencia $secuencia
     * @return \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion
     */    
    public function buscarPorSecuenciaAcceso($keyValues, Secuencia $secuencia);
}
