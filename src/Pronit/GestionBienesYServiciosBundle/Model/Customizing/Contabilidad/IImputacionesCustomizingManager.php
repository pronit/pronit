<?php

namespace Pronit\GestionBienesYServiciosBundle\Model\Customizing\Contabilidad;

use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;
use Pronit\CoreBundle\Entity\Documentos\ClasificadorItem;
use Pronit\GestionBienesYServiciosBundle\Entity\CategoriaValoracion;

/**
 * @author ldelia
 */
interface IImputacionesCustomizingManager
{
    public function getCuenta(ClasificadorItem $clasificador, OperacionContable $operacionContable, CategoriaValoracion $categoriaValoracion);    
}
