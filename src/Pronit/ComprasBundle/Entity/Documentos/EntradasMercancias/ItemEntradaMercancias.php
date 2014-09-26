<?php

namespace Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias;

use Doctrine\ORM\Mapping as ORM;

use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;

/**
 *
 * @author ldelia
 * @ORM\Entity
*/
class ItemEntradaMercancias extends ItemAbastecimientoExterno
{
    public function __toString()
    {
        return $this->getId();
    }    
}