<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Estados\Facturacion;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Finalizado extends EstadoFacturacion
{
    public function __toString()
    {
        return 'Finalizado';
    }
}
