<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Facturas;

use Doctrine\ORM\Mapping as ORM;
use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Symfony\Component\Serializer\Exception\Exception;

/**
 *
 * @author gcaseres
 * @ORM\Entity
 */
class ItemFactura extends ItemAbastecimientoExterno {

    public function setClasificador(ClasificadorItem $clasificador) {
        if (!$clasificador instanceof ClasificadorItemFactura) {
            throw new Exception("Los items de facturas solo admiten clasificadores de items de facturas.");
        }
        parent::setClasificador($clasificador);
    }
    
    public function __toString() {
        return $this->getId();
    }

}
