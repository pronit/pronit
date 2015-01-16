<?php

namespace Pronit\CoreBundle\Entity\Personas;

use Doctrine\ORM\Mapping as ORM;


/** 
 * @ORM\Entity
 */
class Proveedor extends Acreedor
{    
    
    public function __toString(){
        return (string) "Proveedor " . $this->getPersona();
    }
}
