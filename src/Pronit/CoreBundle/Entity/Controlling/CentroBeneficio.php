<?php

namespace Pronit\CoreBundle\Entity\Controlling;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 */
class CentroBeneficio extends ObjetoCosto
{
    public function __toString() 
    {
        return $this->getNombre() . ' (Centro de Beneficio)';
    }

}
