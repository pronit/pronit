<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Entregas;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SinEntregar extends EstadoEntrega
{
    public function __toString()
    {
        return 'Sin Entregar';
    }
}
