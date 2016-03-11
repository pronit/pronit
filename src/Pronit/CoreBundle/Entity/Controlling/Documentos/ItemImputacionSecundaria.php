<?php

namespace Pronit\CoreBundle\Entity\Controlling\Documentos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\CoreBundle\Entity\Documentos\Item;

abstract class ItemImputacionSecundaria extends Item
{
    /**
     * @ORM\Column(type="float")
     */    
    protected $importe;    

    function getImporte() 
    {
        return $this->importe;
    }

    function setImporte($importe) 
    {
        $this->importe = $importe;
    }    
}

