<?php

namespace Pronit\CoreBundle\Entity\Controlling\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Controlling\Imputacion;

class ItemEmisor extends ItemImputacionSecundaria 
{
    /** 
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Controlling\Imputacion") 
     */    
    protected $imputacion;        
    
    /**
     * 
     * @return Imputacion
     */
    function getImputacion() 
    {
        return $this->imputacion;
    }

    function setImputacion(Imputacion $imputacion) 
    {
        $this->imputacion = $imputacion;
    }    
}

