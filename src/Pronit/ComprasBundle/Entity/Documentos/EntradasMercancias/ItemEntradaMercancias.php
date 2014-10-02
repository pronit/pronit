<?php

namespace Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias;

use Doctrine\ORM\Mapping as ORM;
use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Symfony\Component\Serializer\Exception\Exception;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class ItemEntradaMercancias extends ItemAbastecimientoExterno {

    public function setClasificador(ClasificadorItem $clasificador) {
        if (!$clasificador instanceof ClasificadorItemEntradaMercancias) {
            throw new Exception("Los items de entrada de mercancias solo admiten clasificadores de items de entrada de mercancias.");
        }
        parent::setClasificador($clasificador);
    }

    public function __toString() {
        return $this->getId();
    }

}
