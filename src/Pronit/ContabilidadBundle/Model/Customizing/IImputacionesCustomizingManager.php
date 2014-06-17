<?php

namespace Pronit\ContabilidadBundle\Model\Customizing;

use Pronit\CoreBundle\Entity\Contabilidad\OperacionContable;

/**
 * @author ldelia
 */
interface IImputacionesCustomizingManager
{
    public function getCuenta(OperacionContable $operacionContable);    
}
