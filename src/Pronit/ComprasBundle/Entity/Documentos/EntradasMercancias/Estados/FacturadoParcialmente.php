<?php

namespace Pronit\ComprasBundle\Entity\Documentos\EntradasMercancias\Estados;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class FacturadoParcialmente extends EstadoEntradaMercancias
{
    public function __toString()
    {
        return 'Facturado Parcialmente';
    }    
}
