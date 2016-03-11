<?php

namespace Pronit\CoreBundle\Entity\Controlling\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\CoreBundle\Entity\Controlling\ObjetoCosto;

class ItemEmisor extends ItemImputacionSecundaria 
{
    /** 
     * @ORM\ManyToOne(targetEntity="Pronit\CoreBundle\Entity\Controlling\ObjetoCosto") 
     */    
    protected $objetoCosto;    
    
    /**
     * 
     * @return ObjetoCosto
     */
    function getObjetoCosto() 
    {
        return $this->objetoCosto;
    }

    function setObjetoCosto(ObjetoCosto $objetoCosto) 
    {
        $this->objetoCosto = $objetoCosto;
    }    
    
}

