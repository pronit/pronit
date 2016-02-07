<?php

namespace Pronit\CoreBundle\Entity\Controlling;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of CentroCosto
 *
 * @ORM\Entity
 */
class CentroCosto extends ObjetoCosto
{
    public function __toString() 
    {
        return $this->getNombre() . ' (Centro de Costo)';
    }

}
