<?php

namespace Pronit\CoreBundle\Model\Aspectos;

use Pronit\CoreBundle\Entity\Operaciones\Operacion;

/**
 *
 * @author ldelia
 */
interface IAspectoManager 
{
    /**
     * 
     * @param Operacion $operacion
     */
    public function set(Operacion $operacion);
    
    /**
     * 
     * @return Aspecto
     * @param Operacion $operacion
     */
    public function get(Operacion $operacion);
    
    /**
     * @return boolean 
     * @param Operacion $operacion
     */
    public function has(Operacion $operacion);
}
