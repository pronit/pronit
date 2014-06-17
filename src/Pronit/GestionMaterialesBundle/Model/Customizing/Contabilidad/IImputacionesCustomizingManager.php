<?php

namespace Pronit\GestionMaterialesBundle\Model\Customizing\Contabilidad;

use Pronit\CoreBundle\Entity\Contabilidad\OperacionContable;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\GestionMaterialesBundle\Entity\CategoriaValoracion;

/**
 * @author ldelia
 */
interface IImputacionesCustomizingManager
{
    public function getCuenta(ClasificadorItem $clasificador, OperacionContable $operacionContable, CategoriaValoracion $categoriaValoracion);    
}
