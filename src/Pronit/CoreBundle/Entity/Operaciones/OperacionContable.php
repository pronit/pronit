<?php

namespace Pronit\CoreBundle\Entity\Operaciones;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Contabilidad\ClaveContabilizacion;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;
/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class OperacionContable extends Operacion
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Contabilidad\ClaveContabilizacion")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $claveContabilizacion;    
    
    
    /**
     * 
     * @return ClaveContabilizacion
     */
    public function getClaveContabilizacion()
    {
        return $this->claveContabilizacion;
    }

    public function setClaveContabilizacion(ClaveContabilizacion $claveContabilizacion)
    {
        $this->claveContabilizacion = $claveContabilizacion;
    }
    
    protected function procesar($returnValue) 
    {
        return $returnValue;
    }    
}
