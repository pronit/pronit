<?php

namespace Pronit\CoreBundle\Entity\Documentos\Ventas\Estados\Facturacion;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SinFacturar extends EstadoFacturacion
{
    public function __toString()
    {
        return 'Sin Facturar';
    }
}
