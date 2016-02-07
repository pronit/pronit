<?php

namespace Pronit\CoreBundle\Entity\Controlling;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 */
class Orden extends ObjetoCosto
{
    public function __toString() 
    {
        return $this->getNombre() . ' (Orden)';
    }
}
