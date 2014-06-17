<?php

namespace Pronit\CustomizingBundle\Model\Operaciones;

use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;

/**
 *
 * @author ldelia
 */
interface IOperacionesCustomizingManager
{
    public function getOperacionesContablesByClasificadorItem( ClasificadorItem $clasificador );
}
