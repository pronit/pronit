<?php

namespace Pronit\CoreBundle\Entity\Operaciones;

use Doctrine\ORM\Mapping as ORM;
use Pronit\CoreBundle\Entity\Operaciones\Operacion;

/**
 *
 * @author gcaseres
 * @ORM\Entity
 */
class OperacionCalculo extends Operacion {

    protected function procesar($returnValue) {
        if (!is_numeric($returnValue)) {
            throw new \Exception("La operación debe devolver un valor numérico.");
        }
        return $returnValue;
    }

}
