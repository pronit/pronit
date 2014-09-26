<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Pedidos;

use Doctrine\ORM\Mapping as ORM;

use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;

/**
 *
 * @author ldelia
 * @ORM\Entity
*/
class ItemPedido extends ItemAbastecimientoExterno
{
    public function __toString()
    {
        return $this->getId();
    }
}

