<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Facturas;

use Pronit\ComprasBundle\Entity\Documentos\ItemAbastecimientoExterno;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author gcaseres
 * @ORM\Entity
 */
class ItemFactura extends ItemAbastecimientoExterno {

    public function __toString() {
        return $this->getId();
    }

}
