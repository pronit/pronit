<?php

namespace Pronit\CoreBundle\Entity\Controlling\Documentos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Controlling\Imputacion;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */

class ItemEmisor extends ItemImputacionSecundaria 
{
    /**
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Controlling\Imputacion") 
     */
    protected $imputacion;

    public function setImputacion(Imputacion $imputacion)
    {
        $this->imputacion = $imputacion;        
    }
    
    /**
     * 
     * @return Imputacion
     */
    public function getImputacion() {
        return $this->imputacion;
    }

    /**
     * 
     * @return ObjetoCostro
     */
    public function getObjetoCosto() {
        return $this->imputacion->getObjetoCosto();
    }

}
