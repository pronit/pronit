<?php

namespace Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\Estados;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SinFacturar extends EstadoEntradaMercancias
{
    public function __toString()
    {
        return 'Sin Facturar';
    }
}
