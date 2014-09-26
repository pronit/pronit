<?php

namespace Pronit\ComprasBundle\Entity\Documentos\Pedidos\Estados;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SinEntregar extends EstadoPedido
{
    public function __toString()
    {
        return 'Sin Entregar';
    }
}
