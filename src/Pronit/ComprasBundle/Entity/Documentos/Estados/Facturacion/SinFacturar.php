<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion;

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
