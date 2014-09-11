<?php

namespace Pronit\CoreBundle\Model\Automatizacion\Secuencias;

use \Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ClaseCondicion;
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
     * @param \Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ClaseCondicion $claseCondicion
     * @param \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\TablaCondicion $tablaCondicion
     * @return \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion | null
     */
    public function buscarPorTablaCondicion( $keyValues, ClaseCondicion $claseCondicion, TablaCondicion $tablaCondicion);
    
    /**
     * 
     * @param type $keyValues
     * @param \Pronit\CoreBundle\Entity\Automatizacion\EsquemasCalculo\ClaseCondicion $claseCondicion
     * @param \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\Secuencia $secuencia
     * @return \Pronit\CoreBundle\Entity\Automatizacion\Secuencias\RegistroCondicion
     */    
    public function buscarPorSecuenciaAcceso($keyValues, ClaseCondicion $claseCondicion, Secuencia $secuencia);
}
