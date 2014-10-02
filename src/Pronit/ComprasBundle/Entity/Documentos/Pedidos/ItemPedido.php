<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Pedidos;

use Doctrine\ORM\Mapping as ORM;
use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Symfony\Component\Serializer\Exception\Exception;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class ItemPedido extends ItemAbastecimientoExterno {

    public function setClasificador(ClasificadorItem $clasificador) {
        if (!$clasificador instanceof ClasificadorItemPedido) {
            throw new Exception("Los items de pedido solo admiten clasificadores de items de pedido.");
        }
        parent::setClasificador($clasificador);
    }

    public function __toString() {
        return $this->getId();
    }

}
