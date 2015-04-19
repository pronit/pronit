<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\Estados;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Contabilizado extends EstadoVentas
{
    public function __toString()
    {
        return 'Contabilizado';
    }
}
