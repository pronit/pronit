<?php

namespace Pronit\CustomizingBundle\Model\Operaciones;

use Pronit\CoreBundle\Entity\Documentos\ClaseDocumento;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;

/**
 *
 * @author ldelia
 */
interface IOperacionesCustomizingManager {

    public function getMappingsByClasificadorItem(ClasificadorItem $clasificador);
    public function getMappingsCondicionPagosByClaseDocumento(ClaseDocumento $claseDocumento);
}
