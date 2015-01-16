<?php

namespace Pronit\CoreBundle\Model\Contabilidad\Customizing;

use Pronit\CoreBundle\Entity\Operaciones\OperacionContable;

/**
 * @author ldelia
 */
interface IImputacionesCustomizingManager
{
    public function getCuenta(OperacionContable $operacionContable);    
}
