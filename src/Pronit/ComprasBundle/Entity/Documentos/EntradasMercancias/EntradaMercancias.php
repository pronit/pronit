<?php

namespace Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias;

use Exception;
use Doctrine\ORM\Mapping as ORM;

use Pronit\ComprasBundle\Entity\Documentos\AbastecimientoExterno;

use Pronit\CoreBundle\Entity\Documentos\Item;
use Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\ItemEntradaMercancias;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class EntradaMercancias extends AbastecimientoExterno
{
    public function addItem(Item $item)
    {        
        if (! $item instanceof ItemEntradaMercancias )
        {
            throw new Exception;
        }
        parent::addItem($item);
    }
}

