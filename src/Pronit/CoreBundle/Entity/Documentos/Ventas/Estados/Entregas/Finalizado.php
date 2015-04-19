<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Entregas;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Finalizado extends EstadoEntrega
{
    public function __toString()
    {
        return 'Finalizado';
    }
}
